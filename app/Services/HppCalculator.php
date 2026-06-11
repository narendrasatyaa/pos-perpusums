<?php

namespace App\Services;

use App\Models\TransactionItem;
use App\Models\Product;
use Illuminate\Support\Carbon;

class HppCalculator
{
    /**
     * Calculate aggregated profit for a given period.
     * Returns integers (same unit as price fields in DB).
     */
    public function profitForPeriod($from = null, $to = null): array
    {
        $query = TransactionItem::query()->with(['transaction', 'product'])
            ->whereHas('transaction', function ($q) {
                $q->whereNotNull('paid_at');
            });

        if ($from) {
            $query->whereHas('transaction', fn($q) => $q->where('paid_at', '>=', $from));
        }

        if ($to) {
            $query->whereHas('transaction', fn($q) => $q->where('paid_at', '<=', $to));
        }

        $totals = [
            'total_profit' => 0,
            'consignment_profit' => 0,
            'rows' => [],
        ];

        $query->chunk(500, function ($items) use (&$totals) {
            foreach ($items as $item) {
                $product = $item->product;
                $price = intval($item->price);
                $qty = intval($item->quantity);

                $cost = 0;
                if ($item->cost_price !== null) {
                    $cost = intval($item->cost_price);
                } else if ($product) {
                    if ($product->is_consignment) {
                        if ($product->consignor_share_type === 'nominal') {
                            $cost = intval($product->consignor_share);
                        } else {
                            $share = intval($product->consignor_share) ?: 0;
                            $cost = intdiv($price * $share, 100);
                        }
                    } else {
                        $cost = intval($product->cost_price) ?: 0;
                    }
                }

                $profit = ($price - $cost) * $qty;

                if ($product && $product->is_consignment) {
                    $totals['consignment_profit'] += $profit;
                }

                $totals['total_profit'] += $profit;

                $totals['rows'][] = [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'profit' => $profit,
                    'quantity' => $qty,
                ];
            }
        });

        return $totals;
    }

    public function topProducts(int $limit = 5, $from = null, $to = null): array
    {
        $items = TransactionItem::query()->with('product')
            ->whereHas('transaction', fn($q) => $q->whereNotNull('paid_at'));

        if ($from) $items->whereHas('transaction', fn($q) => $q->where('paid_at', '>=', $from));
        if ($to) $items->whereHas('transaction', fn($q) => $q->where('paid_at', '<=', $to));

        $grouped = [];
        $items->chunk(500, function ($rows) use (&$grouped) {
            foreach ($rows as $item) {
                $product = $item->product;
                $price = intval($item->price);
                $qty = intval($item->quantity);

                $cost = 0;
                if ($item->cost_price !== null) {
                    $cost = intval($item->cost_price);
                } else if ($product) {
                    if ($product->is_consignment) {
                        if ($product->consignor_share_type === 'nominal') {
                            $cost = intval($product->consignor_share);
                        } else {
                            $share = intval($product->consignor_share) ?: 0;
                            $cost = intdiv($price * $share, 100);
                        }
                    } else {
                        $cost = intval($product->cost_price) ?: 0;
                    }
                }

                $profit = ($price - $cost) * $qty;

                $pid = $item->product_id;
                if (!isset($grouped[$pid])) {
                    $grouped[$pid] = ['product_id' => $pid, 'product_name' => $item->product_name, 'profit' => 0, 'quantity' => 0];
                }

                $grouped[$pid]['profit'] += $profit;
                $grouped[$pid]['quantity'] += $qty;
            }
        });

        usort($grouped, fn($a, $b) => $b['profit'] <=> $a['profit']);

        return array_slice($grouped, 0, $limit);
    }
}
