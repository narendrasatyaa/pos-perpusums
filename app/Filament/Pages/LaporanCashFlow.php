<?php

namespace App\Filament\Pages;

use App\Models\CashFlow;
use App\Models\Transaction;
use App\Models\User;
use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class LaporanCashFlow extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected string $view = 'filament.pages.laporan-cash-flow';
    protected static ?string $title = 'Laporan Cashflow';
    protected static ?string $navigationLabel = 'Laporan Cashflow';
    protected static \UnitEnum|string|null $navigationGroup = 'Keuangan & Kas';
    protected static ?int $navigationSort = 2;

    public ?string $from = null;
    public ?string $until = null;

    public static function canViewAny(): bool
    {
        return in_array(auth()->user()?->role, [User::ROLE_ADMIN, User::ROLE_FINANCE]);
    }

    public function mount()
    {
        $this->from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->until = Carbon::now()->format('Y-m-d');
    }

    public function updatedFrom()
    {
        $this->dispatch('filterUpdated', from: $this->from, until: $this->until);
    }

    public function updatedUntil()
    {
        $this->dispatch('filterUpdated', from: $this->from, until: $this->until);
    }

    public function getCashFlowData(): array
    {
        $fromDateTime = $this->from . ' 00:00:00';
        $untilDateTime = $this->until . ' 23:59:59';

        // 1. Total POS Sales (Paid)
        $totalSales = Transaction::where('status', 'paid')
            ->whereBetween('paid_at', [$fromDateTime, $untilDateTime])
            ->sum('total');

        // 2. Total Cash In (Other Income)
        $totalCashIn = CashFlow::where('type', 'in')
            ->whereBetween('transaction_date', [$this->from, $this->until])
            ->sum('amount');

        // 3. Total Expense
        $totalExpense = CashFlow::where('type', 'out')
            ->whereBetween('transaction_date', [$this->from, $this->until])
            ->sum('amount');

        // 4. Expense Breakdown by Category
        $expenseBreakdown = CashFlow::where('type', 'out')
            ->whereBetween('transaction_date', [$this->from, $this->until])
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        // 5. Cash In Breakdown by Category
        $incomeBreakdown = CashFlow::where('type', 'in')
            ->whereBetween('transaction_date', [$this->from, $this->until])
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        // Ensure all categories have a value
        $categoriesOut = ['bahan_baku' => 0, 'gaji' => 0, 'operasional' => 0, 'lain_lain' => 0];
        foreach ($categoriesOut as $key => $val) {
            $categoriesOut[$key] = $expenseBreakdown[$key] ?? 0;
        }

        $categoriesIn = ['modal' => 0, 'sewa' => 0, 'lain_lain' => 0];
        foreach ($categoriesIn as $key => $val) {
            $categoriesIn[$key] = $incomeBreakdown[$key] ?? 0;
        }

        $totalIncomeTotal = $totalSales + $totalCashIn;
        $netProfit = $totalIncomeTotal - $totalExpense;

        return [
            'total_sales' => $totalSales,
            'total_cash_in' => $totalCashIn,
            'total_income' => $totalIncomeTotal,
            'total_expense' => $totalExpense,
            'net_profit' => $netProfit,
            'expenses_by_category' => $categoriesOut,
            'incomes_by_category' => $categoriesIn,
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\CashFlowOverview::class,
            \App\Filament\Widgets\CashFlowTrendChart::class,
        ];
    }

    protected function getHeaderWidgetsData(): array
    {
        return [
            'from' => $this->from,
            'until' => $this->until,
        ];
    }
}
