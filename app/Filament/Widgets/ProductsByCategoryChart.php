<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;

class ProductsByCategoryChart extends ChartWidget
{
    protected ?string $heading = 'Produk per Kategori';
    protected ?string $description = 'Distribusi jumlah produk di setiap kategori';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $categories = Category::withCount('products')
            ->having('products_count', '>', 0)
            ->orderByDesc('products_count')
            ->get();

        $palette = [
            '#323986', '#2ac4ea', '#ecc25c', '#c9b27e',
            '#3e426b', '#60a5fa', '#f97316', '#a78bfa',
        ];

        return [
            'datasets' => [
                [
                    'label'           => 'Jumlah Produk',
                    'data'            => $categories->pluck('products_count')->toArray(),
                    'backgroundColor' => collect($palette)->take($categories->count())->values()->toArray(),
                    'borderWidth'     => 2,
                    'borderColor'     => '#ffffff',
                ],
            ],
            'labels' => $categories->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels'   => ['padding' => 16, 'usePointStyle' => true],
                ],
            ],
            'cutout' => '65%',
        ];
    }
}
