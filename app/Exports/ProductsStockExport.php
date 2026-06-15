<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class ProductsStockExport implements FromQuery, WithHeadings, WithMapping
{
    protected Builder $query;

    public function __construct(Builder $query)
    {
        // Clone and eager load category
        $this->query = clone $query;
        $this->query->with('category');

        // Add sales quantity for the last 30 days
        $this->query->withSum(['transactionItems as sales_qty_30_days' => function ($q) {
            $q->whereHas('transaction', function ($t) {
                $t->where('status', 'paid')
                  ->where('paid_at', '>=', now()->subDays(30));
            });
        }], 'quantity');

        // Add last sale datetime using subquery (handling type cast for safety)
        $this->query->selectSub(function ($q) {
            $q->select('transactions.paid_at')
              ->from('transaction_items')
              ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
              ->whereRaw('transaction_items.product_id = CAST(products.id AS CHAR)')
              ->where('transactions.status', 'paid')
              ->orderByDesc('transactions.paid_at')
              ->limit(1);
        }, 'last_sale_at');
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'SKU',
            'Nama Produk',
            'Kategori',
            'Harga Jual',
            'HPP / Harga Modal',
            'Stok Saat Ini',
            'Status Stok',
            'Total Terjual (30 Hari Terakhir)',
            'Penjualan Terakhir',
            'Status Gerak (ABC-XYZ)',
        ];
    }

    /**
     * @param \App\Models\Product $product
     */
    public function map($product): array
    {
        // Cost price / HPP calculation (handling consignment)
        $costPrice = 0;
        if ($product->is_consignment) {
            if ($product->consignor_share_type === 'nominal') {
                $costPrice = $product->consignor_share;
            } else {
                $share = intval($product->consignor_share) ?: 0;
                $costPrice = intval(intdiv($product->price * $share, 100));
            }
        } else {
            $costPrice = $product->cost_price ?? 0;
        }

        // Stock status
        $stockStatus = $product->stock <= $product->min_stock ? 'Rendah' : 'Normal';

        // Movement status (Dead Stock, Slow Moving, Aktif)
        $sales30Days = intval($product->sales_qty_30_days) ?: 0;
        $lastSaleAt = $product->last_sale_at ? Carbon::parse($product->last_sale_at) : null;

        if (!$lastSaleAt || $lastSaleAt->lt(now()->subDays(60))) {
            $movementStatus = 'Dead Stock';
        } elseif ($sales30Days < 5) {
            $movementStatus = 'Slow Moving';
        } else {
            $movementStatus = 'Aktif';
        }

        return [
            $product->sku,
            $product->name,
            $product->category?->name ?? '-',
            'Rp ' . number_format($product->price, 0, ',', '.'),
            'Rp ' . number_format($costPrice, 0, ',', '.'),
            $product->stock . ' ' . $product->unit,
            $stockStatus,
            $sales30Days,
            $lastSaleAt ? $lastSaleAt->format('d M Y, H:i') : '-',
            $movementStatus,
        ];
    }
}
