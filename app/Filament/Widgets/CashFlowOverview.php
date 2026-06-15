<?php

namespace App\Filament\Widgets;

use App\Models\CashFlow;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;

class CashFlowOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    public ?string $from = null;
    public ?string $until = null;

    #[On('filterUpdated')]
    public function updateFilter(string $from, string $until)
    {
        $this->from = $from;
        $this->until = $until;
    }

    protected function getStats(): array
    {
        $from = $this->from ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $until = $this->until ?? Carbon::now()->format('Y-m-d');
        
        $fromDateTime = $from . ' 00:00:00';
        $untilDateTime = $until . ' 23:59:59';

        // 1. Total POS Sales (Paid)
        $totalSales = Transaction::where('status', 'paid')
            ->whereBetween('paid_at', [$fromDateTime, $untilDateTime])
            ->sum('total');

        // 2. Total Cash In (Other Income)
        $totalCashIn = CashFlow::where('type', 'in')
            ->whereBetween('transaction_date', [$from, $until])
            ->sum('amount');

        // 3. Total Expense
        $totalExpense = CashFlow::where('type', 'out')
            ->whereBetween('transaction_date', [$from, $until])
            ->sum('amount');

        $totalIncome = $totalSales + $totalCashIn;
        $netProfit = $totalIncome - $totalExpense;

        return [
            Stat::make('Total Pemasukan', 'Rp ' . number_format($totalIncome, 0, ',', '.'))
                ->description('POS: Rp ' . number_format($totalSales, 0, ',', '.') . ' | Lainnya: Rp ' . number_format($totalCashIn, 0, ',', '.'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Total Pengeluaran', 'Rp ' . number_format($totalExpense, 0, ',', '.'))
                ->description('Operasional, gaji, & bahan baku')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),

            Stat::make('Saldo Bersih (Net Profit)', 'Rp ' . number_format($netProfit, 0, ',', '.'))
                ->description($netProfit >= 0 ? 'Kafe Untung / Surplus' : 'Kafe Rugi / Defisit')
                ->descriptionIcon($netProfit >= 0 ? 'heroicon-m-face-smile' : 'heroicon-m-face-frown')
                ->color($netProfit >= 0 ? 'success' : 'danger'),
        ];
    }
}
