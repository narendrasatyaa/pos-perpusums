<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

// class ProductPriceRangeChart extends ChartWidget
// {
//     protected ?string $heading = 'Distribusi Harga Menu';
//     protected ?string $description = 'Jumlah menu berdasarkan rentang harga';
//     protected static ?int $sort = 4;
//     protected int|string|array $columnSpan = 'full';

//     protected function getData(): array
//     {
//         $ranges = [
//             '< Rp 10.000'          => [0, 9999],
//             'Rp 10.000 - 25.000'   => [10000, 25000],
//             'Rp 25.001 - 50.000'   => [25001, 50000],
//             'Rp 50.001 - 100.000'  => [50001, 100000],
//             '> Rp 100.000'         => [100001, PHP_INT_MAX],
//         ];

//         $counts = [];
//         foreach ($ranges as $label => [$min, $max]) {
//             $counts[] = Product::whereBetween('price', [$min, $max])->count();
//         }

//         return [
//             'datasets' => [
//                 [
//                     'label'           => 'Jumlah Menu',
//                     'data'            => $counts,
//                     'backgroundColor' => '#323986',
//                     'borderColor'     => '#2a2f70',
//                     'borderRadius'    => 6,
//                     'borderWidth'     => 0,
//                 ],
//             ],
//             'labels' => array_keys($ranges),
//         ];
//     }

//     protected function getType(): string
//     {
//         return 'bar';
//     }

//     protected function getOptions(): array
//     {
//         return [
//             'plugins' => [
//                 'legend' => ['display' => false],
//             ],
//             'scales' => [
//                 'y' => [
//                     'beginAtZero' => true,
//                     'ticks' => ['stepSize' => 1],
//                     'grid'  => ['color' => 'rgba(0,0,0,0.05)'],
//                 ],
//                 'x' => [
//                     'grid' => ['display' => false],
//                 ],
//             ],
//         ];
//     }
// }
