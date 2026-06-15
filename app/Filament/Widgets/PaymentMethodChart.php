<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class PaymentMethodChart extends ChartWidget
{
    protected ?string $heading = 'Metode Pembayaran (Bulan Ini)';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $startOfMonth = Carbon::now()->startOfMonth();

        $cashSales = Transaction::where('status', 'paid')
            ->where('payment_method', 'cash')
            ->where('created_at', '>=', $startOfMonth)
            ->sum('total');

        $qrisSales = Transaction::where('status', 'paid')
            ->where('payment_method', 'qris_static')
            ->where('created_at', '>=', $startOfMonth)
            ->sum('total');

        return [
            'datasets' => [
                [
                    'label' => 'Total Pendapatan (Rp)',
                    'data' => [$cashSales, $qrisSales],
                    'backgroundColor' => ['#3b82f6', '#ecc25c'],
                    'borderWidth' => 2,
                    'borderColor' => '#ffffff',
                ],
            ],
            'labels' => ['Cash / Tunai', 'QRIS Static'],
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
                    'labels' => ['padding' => 16, 'usePointStyle' => true],
                ],
            ],
            'cutout' => '65%',
        ];
    }
}
