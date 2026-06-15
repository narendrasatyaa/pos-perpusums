<?php

namespace App\Filament\Resources\StockMutation\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StockMutationTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Tanggal & Waktu')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                TextColumn::make('product.sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('product.name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Jenis Gerak')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'inbound' => 'Stok Masuk',
                        'outbound' => 'Penjualan POS',
                        'adjustment' => 'Penyesuaian',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'inbound' => 'success',
                        'outbound' => 'danger',
                        'adjustment' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('quantity_before')
                    ->label('Stok Awal')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('quantity_change')
                    ->label('Perubahan')
                    ->formatStateUsing(function ($record) {
                        $qty = (int) $record->quantity_change;
                        $unit = $record->product->unit ?? '';
                        return ($qty > 0 ? '+' : '') . $qty . ' ' . $unit;
                    })
                    ->color(fn ($record) => (int) $record->quantity_change > 0 ? 'success' : 'danger')
                    ->weight('bold')
                    ->sortable(),

                TextColumn::make('quantity_after')
                    ->label('Stok Akhir')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('notes')
                    ->label('Keterangan')
                    ->searchable()
                    ->placeholder('—')
                    ->wrap(),

                TextColumn::make('user.name')
                    ->label('Petugas/Oleh')
                    ->sortable()
                    ->placeholder('System'),
            ])
            ->filters([
                SelectFilter::make('product_id')
                    ->label('Produk')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('type')
                    ->label('Jenis Gerak')
                    ->options([
                        'inbound' => 'Stok Masuk (Supplier)',
                        'outbound' => 'Penjualan POS',
                        'adjustment' => 'Penyesuaian Manual',
                    ]),

                Filter::make('created_at_range')
                    ->form([
                        DatePicker::make('from')->label('Dari Tanggal'),
                        DatePicker::make('until')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn (Builder $q, $d) => $q->whereDate('created_at', '>=', $d))
                            ->when($data['until'], fn (Builder $q, $d) => $q->whereDate('created_at', '<=', $d));
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
            ->actions([])
            ->bulkActions([])
            ->paginated([25, 50, 100, 200]);
    }
}
