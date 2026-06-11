<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\SalesOverview;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\SalesChart;
use App\Filament\Widgets\ProductsByCategoryChart;
use App\Filament\Widgets\LowStockProducts;
use App\Filament\Widgets\ProductAvailabilityChart;
use App\Filament\Widgets\HppSummary;
use App\Filament\Widgets\TopProducts;
use App\Filament\Widgets\PaymentMethodChart;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard Admin';

    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            SalesOverview::class,
            SalesChart::class,
            PaymentMethodChart::class,
            ProductsByCategoryChart::class,
            LowStockProducts::class,
            ProductAvailabilityChart::class,
            HppSummary::class,
            TopProducts::class,
        ];
    }

    public function getColumns(): int | array
    {
        return 3;
    }
}
