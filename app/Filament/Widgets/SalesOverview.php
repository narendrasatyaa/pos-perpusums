<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SalesOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();

        $revenueToday = Transaction::whereDate('created_at', $today)->sum('total');
        $revenueMonth = Transaction::where('created_at', '>=', $startOfMonth)->sum('total');
        $transactionsToday = Transaction::whereDate('created_at', $today)->count();

        // Optional: Get previous day/month for comparison
        $yesterday = Carbon::yesterday();
        $revenueYesterday = Transaction::whereDate('created_at', $yesterday)->sum('total');
        
        $trendToday = $revenueToday - $revenueYesterday;
        $trendIcon = $trendToday >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
        $trendColor = $trendToday >= 0 ? 'success' : 'danger';
        $trendDescription = $trendToday >= 0 ? 'Naik dari kemarin' : 'Turun dari kemarin';

        return [
            Stat::make('Pendapatan Hari Ini', 'Rp ' . number_format($revenueToday, 0, ',', '.'))
                ->description($trendDescription)
                ->descriptionIcon($trendIcon)
                ->color($trendColor),
                
            Stat::make('Pendapatan Bulan Ini', 'Rp ' . number_format($revenueMonth, 0, ',', '.'))
                ->description('Total bulan ' . Carbon::now()->translatedFormat('F'))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),
                
            Stat::make('Transaksi Hari Ini', $transactionsToday)
                ->description('Jumlah pesanan hari ini')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('info'),
        ];
    }
}
