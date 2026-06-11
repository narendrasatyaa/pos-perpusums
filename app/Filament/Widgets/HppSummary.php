<?php

namespace App\Filament\Widgets;

use App\Services\HppCalculator;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class HppSummary extends StatsOverviewWidget
{
    protected static ?int $sort = 5;

    public function getColumnSpan(): int | string | array
    {
        return filament()->getCurrentPanel()?->getId() === 'admin' ? 2 : 'full';
    }

    protected function getStats(): array
    {
        $calculator = app(HppCalculator::class);
        $totals = $calculator->profitForPeriod();

        $totalProfit = $totals['total_profit'] ?? 0;
        $consignmentProfit = $totals['consignment_profit'] ?? 0;
        $top = $calculator->topProducts(1);

        $topLabel = '—';
        if (!empty($top) && isset($top[0]['product_name'])) {
            $topLabel = $top[0]['product_name'] . ' (Rp ' . number_format($top[0]['profit'], 0, ',', '.') . ')';
        }

        return [
            Stat::make('Total Profit', 'Rp ' . number_format($totalProfit, 0, ',', '.'))
                ->description('Semua waktu')
                ->descriptionIcon('heroicon-m-presentation-chart-line')
                ->color('success'),

            Stat::make('Profit Barang Titipan', 'Rp ' . number_format($consignmentProfit, 0, ',', '.'))
                ->description('Dari barang titipan')
                ->descriptionIcon('heroicon-m-arrow-path-rounded-square')
                ->color('warning'),

            Stat::make('Top Produk (Profit)', $topLabel)
                ->description('Produk dengan profit tertinggi')
                ->color('primary'),
        ];
    }
}
