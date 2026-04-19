<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Akses User', User::count())
                ->description('Jumlah pengguna yang dapat mengakses sistem')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success')
                ->chart([5, 6, 3, 4, 7, 2, 6]),
                
            Stat::make('Total Kategori Menu', Category::count())
                ->description('Kategori yang terdaftar')
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('info')
                ->chart([5, 6, 3, 4, 7, 2, 6]), 
                
            Stat::make('Total Produk/Menu', Product::count())
                ->description('Jumlah total menu yang tersedia')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('warning')
                ->chart([5, 6, 3, 4, 7, 2, 6]),
        ];
    }
}
