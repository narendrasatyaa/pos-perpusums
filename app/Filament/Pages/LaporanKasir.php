<?php

namespace App\Filament\Pages;

use App\Models\Transaction;
use App\Models\User;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Page;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class LaporanKasir extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';
    protected string $view = 'filament.pages.laporan-kasir';
    protected static ?string $title = 'Laporan per Kasir';
    protected static ?string $navigationLabel = 'Laporan Kasir';
    protected static \UnitEnum|string|null $navigationGroup = 'Laporan Penjualan';
    protected static ?int $navigationSort = 3;
    public static function canAccess(): bool
    {
        return false;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->select('users.id', 'users.name', 'users.email', 'users.role')
                    ->selectRaw('COUNT(transactions.id) as total_transactions')
                    ->selectRaw('COALESCE(SUM(transactions.total), 0) as total_revenue')
                    ->selectRaw('COALESCE(SUM(CASE WHEN transactions.payment_method = \'cash\' THEN transactions.total ELSE 0 END), 0) as cash_revenue')
                    ->selectRaw('COALESCE(SUM(CASE WHEN transactions.payment_method = \'qris_static\' THEN transactions.total ELSE 0 END), 0) as qris_revenue')
                    ->selectRaw('COALESCE(AVG(transactions.total), 0) as avg_per_transaction')
                    ->selectRaw('MAX(transactions.paid_at) as last_transaction_at')
                    ->join('transactions', function ($join) {
                        $join->on('users.id', '=', 'transactions.user_id')
                             ->where('transactions.status', '=', 'paid');
                    })
                    ->groupBy('users.id', 'users.name', 'users.email', 'users.role')
                    ->orderByDesc('total_revenue')
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Kasir')
                    ->searchable()
                    ->description(fn ($record) => $record->email),

                TextColumn::make('total_transactions')
                    ->label('Jumlah Transaksi')
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->summarize(Sum::make()->label('Total')),

                TextColumn::make('cash_revenue')
                    ->label('Pendapatan Tunai')
                    ->money('IDR')
                    ->sortable()
                    ->color('info')
                    ->weight('semibold')
                    ->summarize(Sum::make()->money('IDR')->label('Total Tunai')),

                TextColumn::make('qris_revenue')
                    ->label('Pendapatan QRIS')
                    ->money('IDR')
                    ->sortable()
                    ->color('warning')
                    ->weight('semibold')
                    ->summarize(Sum::make()->money('IDR')->label('Total QRIS')),

                TextColumn::make('total_revenue')
                    ->label('Total Pendapatan')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold')
                    ->color('success')
                    ->summarize(Sum::make()->money('IDR')->label('Total')),

                // TextColumn::make('avg_per_transaction')
                //     ->label('Rata-rata')
                //     ->money('IDR')
                //     ->sortable(),

                TextColumn::make('last_transaction_at')
                    ->label('Transaksi Terakhir')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('date_range')
                    ->form([
                        DatePicker::make('from')->label('Dari Tanggal'),
                        DatePicker::make('until')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn (Builder $q, $d) => $q->whereDate('transactions.paid_at', '>=', $d))
                            ->when($data['until'], fn (Builder $q, $d) => $q->whereDate('transactions.paid_at', '<=', $d));
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['from'] ?? null) {
                            $indicators['from'] = 'Dari: ' . \Carbon\Carbon::parse($data['from'])->translatedFormat('d M Y');
                        }
                        if ($data['until'] ?? null) {
                            $indicators['until'] = 'Sampai: ' . \Carbon\Carbon::parse($data['until'])->translatedFormat('d M Y');
                        }
                        return $indicators;
                    }),
            ])
            ->paginated(false);
    }
}
