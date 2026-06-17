<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{
    /**
     * Simpan transaksi yang sudah dibayar (lunas).
     */
    public function storePaidOrder(Request $request)
    {
        if (is_string($request->input('items'))) {
            $decodedItems = json_decode($request->input('items'), true);

            if (json_last_error() === JSON_ERROR_NONE) {
                $request->merge(['items' => $decodedItems]);
            }
        }

        $data = $request->validate([
            'order_id' => 'nullable|string|max:50',
            'subtotal' => 'required|integer|min:0',
            'total' => 'required|integer|min:0',
            'paid_amount' => 'required|integer|min:0',
            'change_amount' => 'required|integer|min:0',
            'payment_method' => 'required|string|in:cash,qris_static',
            'transfer_proof' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'voucher_code' => 'nullable|string|max:50',
            'discount_type' => 'nullable|string|max:50',
            'discount_value' => 'nullable|integer|min:0',
            'split_data' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable',
            'items.*.name' => 'nullable|string|max:255',
            'items.*.product_name' => 'nullable|string|max:255',
            'items.*.price' => 'required|integer|min:0',
            'items.*.quantity' => 'nullable|integer|min:1',
            'items.*.qty' => 'nullable|integer|min:1',
        ]);

        try {
            $transaction = DB::transaction(function () use ($data, $request) {
                $subtotal = (int) $data['subtotal'];
                $discountValue = max(0, $subtotal - (int) $data['total']);
                $paymentMethod = (string) ($data['payment_method'] ?? 'cash');
                $voucher = null;

                if ($paymentMethod === 'qris_static' && !$request->hasFile('transfer_proof')) {
                    throw ValidationException::withMessages([
                        'transfer_proof' => 'Bukti transfer wajib diunggah untuk QRIS statis.',
                    ]);
                }

                if (!empty($data['voucher_code'])) {
                    $voucherCode = Str::upper(trim((string) $data['voucher_code']));
                    $voucher = Voucher::query()
                        ->whereRaw('UPPER(code) = ?', [$voucherCode])
                        ->lockForUpdate()
                        ->first();

                    if (
                        !$voucher
                        || !$voucher->isCurrentlyValid()
                        || !$voucher->canBeAppliedToSubtotal($subtotal)
                        || !$voucher->hasValidDiscountConfiguration()
                    ) {
                        throw ValidationException::withMessages([
                            'voucher_code' => 'Voucher tidak valid atau tidak dapat digunakan.',
                        ]);
                    }

                    $discountValue = $voucher->calculateDiscount($subtotal);
                }

                $total = max(0, $subtotal - $discountValue);
                $paidAmount = (int) $data['paid_amount'];
                $requiredStocks = [];

                foreach ($data['items'] as $item) {
                    $quantity = (int) ($item['quantity'] ?? ($item['qty'] ?? 0));
                    $productId = (string) ($item['product_id'] ?? '');

                    if ($quantity <= 0 || $productId === '') {
                        continue;
                    }

                    $requiredStocks[$productId] = ($requiredStocks[$productId] ?? 0) + $quantity;
                }

                $lockedProducts = collect();

                if (!empty($requiredStocks)) {
                    $lockedProducts = Product::query()
                        ->whereIn('id', array_keys($requiredStocks))
                        ->lockForUpdate()
                        ->get()
                        ->keyBy(fn (Product $product) => (string) $product->id);

                    foreach ($requiredStocks as $productId => $requestedQty) {
                        $product = $lockedProducts->get((string) $productId);

                        if (!$product) {
                            throw ValidationException::withMessages([
                                'items' => 'Produk tidak ditemukan. Silakan muat ulang halaman POS.',
                            ]);
                        }

                        if ((int) $product->stock < (int) $requestedQty) {
                            throw ValidationException::withMessages([
                                'items' => "Stok {$product->name} tidak mencukupi. Tersedia {$product->stock}, diminta {$requestedQty}.",
                            ]);
                        }
                    }
                }

                if ($paidAmount < $total) {
                    throw ValidationException::withMessages([
                        'paid_amount' => 'Nominal pembayaran kurang dari total tagihan.',
                    ]);
                }

                $changeAmount = $paidAmount - $total;
                $orderCode = $this->resolveOrderCode($data['order_id'] ?? null);
                $transferProofPath = $request->hasFile('transfer_proof')
                    ? $request->file('transfer_proof')->store('transfer-proofs', 'public')
                    : null;
                $transactionStatus = 'paid';
                $paymentValidationStatus = 'verified';

                $transaction = Transaction::create([
                    'order_code' => $orderCode,
                    'slug' => Str::slug($orderCode) . '-' . Str::lower(Str::random(4)),
                    'user_id' => Auth::id(),
                    'voucher_id' => $voucher?->id,
                    'voucher_code' => $voucher?->code,
                    'discount_type' => $data['discount_type'] ?? ($voucher ? 'voucher_' . $voucher->discount_type : null),
                    'discount_value' => $discountValue,
                    'status' => $transactionStatus,
                    'subtotal' => $subtotal,
                    'total' => $total,
                    'paid_amount' => $paidAmount,
                    'change_amount' => $changeAmount,
                    'payment_method' => $paymentMethod,
                    'transfer_proof_path' => $transferProofPath,
                    'payment_validation_status' => $paymentValidationStatus,
                    'split_data' => isset($data['split_data']) ? json_decode($data['split_data'], true) : null,
                    'paid_at' => now(),
                    'is_active' => true,
                ]);

                foreach ($data['items'] as $item) {
                    $quantity = (int) ($item['quantity'] ?? ($item['qty'] ?? 0));
                    $name = (string) ($item['product_name'] ?? ($item['name'] ?? 'Item'));

                    if ($quantity <= 0) {
                        continue;
                    }

                    $productId = (string) ($item['product_id'] ?? '');
                    $product = $productId !== '' ? $lockedProducts->get($productId) : null;

                    $costPrice = null;
                    if ($product) {
                        if ($product->is_consignment) {
                            if ($product->consignor_share_type === 'nominal') {
                                $costPrice = (int) $product->consignor_share;
                            } else {
                                $share = (int) $product->consignor_share;
                                $costPrice = intval(intdiv((int) $item['price'] * $share, 100));
                            }
                        } else {
                            $costPrice = $product->cost_price;
                        }
                    }

                    $transactionItem = TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $productId,
                        'product_name' => Str::limit($name, 255, ''),
                        'price' => (int) $item['price'],
                        'quantity' => $quantity,
                        'subtotal' => $quantity * (int) $item['price'],
                        'cost_price' => $costPrice,
                        'is_active' => true,
                    ]);

                    if ($product) {
                        $oldStock = (int) $product->stock;
                        $newStock = $oldStock - $quantity;
                        $product->decrement('stock', $quantity);
                        $product->stock = $newStock;

                        // Log stock mutation
                        \App\Models\StockMutation::create([
                            'product_id' => $product->id,
                            'user_id' => $transaction->user_id,
                            'type' => 'outbound',
                            'quantity_before' => $oldStock,
                            'quantity_change' => -$quantity, // Negative for outflow
                            'quantity_after' => $newStock,
                            'reference_id' => $transactionItem->id,
                            'reference_type' => get_class($transactionItem),
                            'notes' => 'Penjualan POS (Nota: ' . $transaction->order_code . ')',
                        ]);
                    }
                }

                if ($voucher) {
                    $voucher->increment('used_count');
                }

                return $transaction;
            });

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan',
                'data' => $transaction->load(['items', 'user']),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal menyimpan transaksi',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function validateVoucher(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50',
            'subtotal' => 'required|integer|min:0',
        ]);

        $voucher = Voucher::query()
            ->whereRaw('UPPER(code) = ?', [Str::upper(trim((string) $data['code']))])
            ->first();

        if (!$voucher || !$voucher->isCurrentlyValid() || !$voucher->hasValidDiscountConfiguration()) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher tidak valid atau sudah tidak aktif.',
            ], 422);
        }

        if (!$voucher->canBeAppliedToSubtotal((int) $data['subtotal'])) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher tidak memenuhi syarat minimal belanja.',
            ], 422);
        }

        $discountAmount = $voucher->calculateDiscount((int) $data['subtotal']);

        return response()->json([
            'success' => true,
            'message' => 'Voucher berhasil diterapkan.',
            'data' => [
                'id' => $voucher->id,
                'code' => $voucher->code,
                'name' => $voucher->name,
                'discount_type' => $voucher->discount_type,
                'discount_value' => (int) $voucher->discount_value,
                'discount_amount' => $discountAmount,
                'max_discount' => $voucher->max_discount,
                'min_purchase' => $voucher->min_purchase,
            ],
        ]);
    }

    private function resolveOrderCode(?string $orderId): string
    {
        if (filled($orderId)) {
            $candidate = Str::upper(trim($orderId));
            $candidate = ltrim($candidate, '#');
            $candidate = preg_replace('/[^A-Z0-9\-]/', '', $candidate) ?: '';

            if ($candidate !== '' && !Transaction::where('order_code', $candidate)->exists()) {
                return $candidate;
            }
        }

        do {
            $candidate = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        } while (Transaction::where('order_code', $candidate)->exists());

        return $candidate;
    }

    /**
     * Ambil list histori transaksi.
     */
    public function indexHistory(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $transactions = Transaction::with(['user', 'items'])
            ->when($status && $status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('order_code', 'like', "%{$search}%")
                      ->orWhereHas('items', function ($qi) use ($search) {
                          $qi->where('product_name', 'like', "%{$search}%");
                      });
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $transactions,
        ]);
    }

    /**
     * Ambil detail satu transaksi.
     */
    public function showHistory($id)
    {
        $transaction = Transaction::with(['items', 'user'])
            ->where(function ($query) use ($id) {
                $query->where('order_code', $id);

                if (is_numeric($id)) {
                    $query->orWhere('id', (int) $id);
                }
            })
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $transaction,
        ]);
    }


    /**
     * nota qr public
     */
    public function showNota($order_code)
    {
        $transaction = Transaction::with(['items', 'user'])
            ->where('order_code', $order_code)
            ->firstOrFail();

        return view('kasir.nota-publik', compact('transaction'));
    }
}
