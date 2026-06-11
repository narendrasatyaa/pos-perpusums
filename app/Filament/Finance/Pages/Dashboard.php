<?php

namespace App\Filament\Finance\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\CashFlowOverview;
use App\Filament\Widgets\HppSummary;
use App\Filament\Widgets\CashFlowTrendChart;
use App\Filament\Widgets\SalesChart;
use App\Filament\Widgets\SalesOverview;
use App\Filament\Widgets\PaymentMethodChart;
use Filament\Widgets\AccountWidget;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard Finance';

    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
            CashFlowOverview::class,
            HppSummary::class,
            CashFlowTrendChart::class,
            PaymentMethodChart::class,
            SalesChart::class,
            SalesOverview::class,
        ];
    }

    public function getColumns(): int | array
    {
        return 3;
    }
}
