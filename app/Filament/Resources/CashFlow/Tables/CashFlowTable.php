<?php

namespace App\Filament\Resources\CashFlow\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CashFlowTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('transaction_date', 'desc')
            ->columns([
                TextColumn::make('transaction_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'in' => 'success',
                        'out' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'in' => 'Cash In',
                        'out' => 'Expense',
                        default => $state,
                    })
                    ->sortable(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'modal' => 'Setor Modal',
                        'sewa' => 'Sewa / Event',
                        'bahan_baku' => 'Bahan Baku',
                        'gaji' => 'Gaji',
                        'operasional' => 'Operasional',
                        'lain_lain' => 'Lain-lain',
                        default => $state,
                    })
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Catatan / Keterangan')
                    ->searchable()
                    ->placeholder('—'),

                TextColumn::make('amount')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold')
                    ->summarize(Sum::make()->money('IDR')->label('Total')),

                TextColumn::make('user.name')
                    ->label('Oleh')
                    ->sortable()
                    ->placeholder('System'),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipe Kas')
                    ->options([
                        'in' => 'Pemasukan (Cash In)',
                        'out' => 'Pengeluaran (Expense)',
                    ]),

                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'modal' => 'Setor Modal',
                        'sewa' => 'Sewa / Event Space',
                        'bahan_baku' => 'Bahan Baku',
                        'gaji' => 'Gaji Karyawan',
                        'operasional' => 'Operasional Kafe',
                        'lain_lain' => 'Lain-lain',
                    ]),

                Filter::make('date_range')
                    ->form([
                        DatePicker::make('from')->label('Dari Tanggal'),
                        DatePicker::make('until')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn (Builder $q, $d) => $q->whereDate('transaction_date', '>=', $d))
                            ->when($data['until'], fn (Builder $q, $d) => $q->whereDate('transaction_date', '<=', $d));
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
            ->recordActions([
                EditAction::make()
                    ->label('Ubah')
                    ->icon('heroicon-o-pencil'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->paginated([10, 25, 50, 100]);
    }
}
