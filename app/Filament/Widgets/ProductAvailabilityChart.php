<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\ChartWidget;

class ProductAvailabilityChart extends ChartWidget
{
    protected ?string $heading = 'Ketersediaan Menu';
    protected ?string $description = 'Perbandingan menu tersedia dan tidak tersedia';
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $available   = Product::where('is_available', true)->count();
        $unavailable = Product::where('is_available', false)->count();

        return [
            'datasets' => [
                [
                    'data'            => [$available, $unavailable],
                    'backgroundColor' => ['#22c55e', '#f97316'],
                    'borderWidth'     => 2,
                    'borderColor'     => '#ffffff',
                ],
            ],
            'labels' => ['Tersedia', 'Tidak Tersedia'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
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
        ];
    }
}
