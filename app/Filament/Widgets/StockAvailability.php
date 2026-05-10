<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StockAvailability extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $lowStock = Product::where('stock', '<=', 10)->where('stock', '>', 0)->count();
        $outOfStock = Product::where('stock', '<=', 0)->count();

        return [
            Stat::make('Total Jenis Produk', $totalProducts)
                ->description('Semua produk terdaftar')
                ->icon('heroicon-o-cube')
                ->color('primary'),
                
            Stat::make('Total Stok Fisik', $totalStock)
                ->description('Jumlah keseluruhan barang')
                ->icon('heroicon-o-archive-box')
                ->color('success'),
                
            Stat::make('Stok Menipis', $lowStock)
                ->description('Stok 10 atau kurang')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning'),
                
            Stat::make('Stok Habis', $outOfStock)
                ->description('Perlu segera direstock')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
