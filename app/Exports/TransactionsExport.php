<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Builder;

class TransactionsExport implements FromQuery, WithHeadings, WithMapping
{
    protected Builder $query;

    public function __construct(Builder $query)
    {
        // Clone query so we don't accidentally modify the source query elsewhere
        // Eager load the user relation to avoid N+1 issues
        $this->query = clone $query;
        $this->query->with('user');
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'Kode Order / Invoice',
            'Kasir',
            'Status',
            'Subtotal',
            'Diskon',
            'Total',
            'Metode Pembayaran',
            'Waktu Bayar',
        ];
    }

    /**
     * @param \App\Models\Transaction $transaction
     */
    public function map($transaction): array
    {
        $statusLabel = match ($transaction->status) {
            'paid' => 'Lunas',
            'draft' => 'Draft',
            'cancelled' => 'Batal',
            default => $transaction->status,
        };

        $paymentMethodLabel = match ($transaction->payment_method) {
            'cash' => 'Cash',
            'qris_static' => 'QRIS',
            default => $transaction->payment_method ?? '-',
        };

        return [
            $transaction->order_code,
            $transaction->user?->name ?? '-',
            $statusLabel,
            'Rp ' . number_format($transaction->subtotal, 0, ',', '.'),
            'Rp ' . number_format($transaction->discount_value, 0, ',', '.'),
            'Rp ' . number_format($transaction->total, 0, ',', '.'),
            $paymentMethodLabel,
            $transaction->paid_at ? $transaction->paid_at->format('d M Y, H:i') : '-',
        ];
    }
}
