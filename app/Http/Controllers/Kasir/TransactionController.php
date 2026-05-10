<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
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
                $transactionStatus = $paymentMethod === 'qris_static' ? 'draft' : 'paid';
                $paymentValidationStatus = $paymentMethod === 'qris_static' ? 'pending' : 'verified';

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
                    'paid_at' => $paymentMethod === 'cash' ? now() : null,
                    'is_active' => true,
                ]);

                foreach ($data['items'] as $item) {
                    $quantity = (int) ($item['quantity'] ?? ($item['qty'] ?? 0));
                    $name = (string) ($item['product_name'] ?? ($item['name'] ?? 'Item'));

                    if ($quantity <= 0) {
                        continue;
                    }

                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => (string) ($item['product_id'] ?? ''),
                        'product_name' => Str::limit($name, 255, ''),
                        'price' => (int) $item['price'],
                        'quantity' => $quantity,
                        'subtotal' => $quantity * (int) $item['price'],
                        'is_active' => true,
                    ]);

                    if (!empty($item['product_id'])) {
                        \App\Models\Product::where('id', $item['product_id'])->decrement('stock', $quantity);
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
    public function indexHistory()
    {
        $transactions = Transaction::with(['user', 'items'])
            ->when(Auth::check(), function ($query) {
                $query->where('user_id', Auth::id());
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
            ->when(Auth::check(), function ($query) {
                $query->where('user_id', Auth::id());
            })
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
