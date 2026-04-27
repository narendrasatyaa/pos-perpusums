<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * Simpan transaksi yang sudah dibayar (lunas).
     */
    public function storePaidOrder(Request $request)
    {
        $data = $request->validate([
            'subtotal' => 'required|integer|min:0',
            'total' => 'required|integer|min:0',
            'paid_amount' => 'required|integer|min:0',
            'change_amount' => 'required|integer|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable',
            'items.*.name' => 'nullable|string|max:255',
            'items.*.product_name' => 'nullable|string|max:255',
            'items.*.price' => 'required|integer|min:0',
            'items.*.quantity' => 'nullable|integer|min:1',
            'items.*.qty' => 'nullable|integer|min:1',
        ]);

        try {
            $transaction = DB::transaction(function () use ($data) {
                $orderCode = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));

                $transaction = Transaction::create([
                    'order_code' => $orderCode,
                    'slug' => Str::slug($orderCode) . '-' . Str::lower(Str::random(4)),
                    'user_id' => Auth::id(),
                    'status' => 'paid',
                    'subtotal' => $data['subtotal'],
                    'total' => $data['total'],
                    'paid_amount' => $data['paid_amount'],
                    'change_amount' => $data['change_amount'],
                    'paid_at' => now(),
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
                }

                return $transaction;
            });

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan',
                'data' => $transaction->load(['items', 'user']),
            ]);
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
