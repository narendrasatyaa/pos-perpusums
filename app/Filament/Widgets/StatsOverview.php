<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $totalProducts    = Product::count();
        $availableProducts = Product::where('is_available', true)->count();
        $unavailableProducts = $totalProducts - $availableProducts;
        $activeCategories = Category::where('is_active', true)->count();
        $totalMenuValue   = Product::where('is_available', true)->sum('price');
        $totalTransactions = Transaction::count();
        $dailyTransactions = Transaction::whereDate('created_at', today())->count();
        $monthlyTransactions = Transaction::whereMonth('created_at', now()->month)->count();

        return [
            Stat::make('Total Menu Tersedia', $availableProducts)
                ->description("{$unavailableProducts} menu tidak tersedia")
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('success')
                ->chart(
                    Product::selectRaw('DATE(created_at) as date, COUNT(*) as total')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->limit(7)
                        ->pluck('total')
                        ->toArray() ?: [0]
                ),

            Stat::make('Total Kategori Aktif', $activeCategories)
                ->description('Dari ' . Category::count() . ' kategori terdaftar')
                ->descriptionIcon('heroicon-m-tag')
                ->color('info'),
                // ->chart([3, 4, 3, 5, $activeCategories]),

            Stat::make('Nilai Inventori', 'Rp ' . number_format($totalMenuValue, 0, ',', '.'))
                ->description('Total harga menu yang tersedia')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),

            Stat::make('Total Pengguna', User::count())
                ->description('Pengguna terdaftar di sistem')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            // Stat::make('Total Transaksi', $totalTransactions)
            //     ->description("{$dailyTransactions} hari ini, {$monthlyTransactions} bulan ini")
            //     ->descriptionIcon('heroicon-m-receipt-percent')
            //     ->color('success')
            //     ->chart(
            //         Transaction::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            //             ->groupBy('date')
            //             ->orderBy('date')
            //             ->limit(7)
            //             ->pluck('total')
            //             ->toArray() ?: [0]
            //     ),
        ];
    }
}
