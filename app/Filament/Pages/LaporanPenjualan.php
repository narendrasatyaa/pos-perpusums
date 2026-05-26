<?php

namespace App\Filament\Pages;

use App\Models\Transaction;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LaporanPenjualan extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';
    protected string $view = 'filament.pages.laporan-penjualan';
    protected static ?string $title = 'Laporan Penjualan';
    protected static ?string $navigationLabel = 'Laporan Penjualan';
    protected static \UnitEnum|string|null $navigationGroup = 'Laporan Penjualan';
    protected static ?int $navigationSort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Transaction::query()->where('status', 'paid')->with('user')
            )
            ->defaultSort('paid_at', 'desc')
            ->columns([
                TextColumn::make('order_code')
                    ->label('Kode Order')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('user.name')
                    ->label('Kasir')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable()
                    ->color('success')
                    ->weight('bold')
                    ->summarize(Sum::make()->money('IDR')->label('Total')),

                TextColumn::make('discount_value')
                    ->label('Diskon')
                    ->money('IDR')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('payment_method')
                    ->label('Metode')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'cash' => 'info',
                        'qris_static' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'cash' => 'Cash',
                        'qris_static' => 'QRIS',
                        default => $state,
                    }),

                TextColumn::make('transfer_proof_path')
                    ->label('Bukti Transfer')
                    ->formatStateUsing(fn (?string $state): string => filled($state) ? 'Lihat Bukti' : '-')
                    ->url(fn ($record): ?string => $record->transfer_proof_url, shouldOpenInNewTab: true)
                    ->icon(fn (?string $state): ?string => filled($state) ? 'heroicon-o-document-magnifying-glass' : null)
                    ->color(fn (?string $state): string => filled($state) ? 'primary' : 'gray')
                    ->toggleable(),

                TextColumn::make('paid_at')
                    ->label('Waktu Bayar')
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
                            ->when($data['from'], fn (Builder $q, $d) => $q->whereDate('paid_at', '>=', $d))
                            ->when($data['until'], fn (Builder $q, $d) => $q->whereDate('paid_at', '<=', $d));
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

                SelectFilter::make('payment_method')
                    ->label('Metode Bayar')
                    ->options([
                        'cash' => 'Cash',
                        'qris_static' => 'QRIS',
                    ]),
            ])
            ->paginated([10, 25, 50, 100]);
    }
}
