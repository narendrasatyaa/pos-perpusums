<?php

namespace App\Filament\Widgets;

use App\Models\CashFlow;
use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;

class CashFlowTrendChart extends ChartWidget
{
    protected ?string $heading = 'Perbandingan Arus Kas Harian';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 2;
    protected ?string $maxHeight = '250px';

    public ?string $from = null;
    public ?string $until = null;

    #[On('filterUpdated')]
    public function updateFilter(string $from, string $until)
    {
        $this->from = $from;
        $this->until = $until;
    }

    protected function getData(): array
    {
        $from = $this->from ? Carbon::parse($this->from) : Carbon::now()->startOfMonth();
        $until = $this->until ? Carbon::parse($this->until) : Carbon::now();

        // Calculate differences in days
        $days = $from->diffInDays($until) + 1;

        // Cap chart data points to a maximum of 30 days to keep the graph readable
        if ($days > 30) {
            $days = 30;
            $from = $until->copy()->subDays(29);
        }

        $labels = [];
        $incomeData = [];
        $expenseData = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $carbonDate = $until->copy()->subDays($i);
            $date = $carbonDate->format('Y-m-d');
            $labels[] = $carbonDate->translatedFormat('d M');

            // 1. POS Sales on this day
            $posSales = Transaction::where('status', 'paid')
                ->whereDate('paid_at', $date)
                ->sum('total');

            // 2. Cash In on this day
            $cashIn = CashFlow::where('type', 'in')
                ->whereDate('transaction_date', $date)
                ->sum('amount');

            // 3. Expense on this day
            $expense = CashFlow::where('type', 'out')
                ->whereDate('transaction_date', $date)
                ->sum('amount');

            $incomeData[] = $posSales + $cashIn;
            $expenseData[] = $expense;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Pemasukan (Rp)',
                    'data' => $incomeData,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                ],
                [
                    'label' => 'Total Pengeluaran (Rp)',
                    'data' => $expenseData,
                    'borderColor' => '#f43f5e',
                    'backgroundColor' => 'rgba(244, 63, 94, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
