<?php

namespace App\Filament\Resources\StockAdjustment\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StockAdjustmentTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('adjusted_at', 'desc')
            ->columns([
                TextColumn::make('adjusted_at')
                    ->label('Tanggal')
                    ->date('d M Y')
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
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn ($record) => $record->getTypeLabel())
                    ->color(fn (string $state): string => match ($state) {
                        'waste' => 'danger',
                        'damage' => 'danger',
                        'correction_add' => 'success',
                        'correction_sub' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('quantity')
                    ->label('Kuantitas')
                    ->formatStateUsing(function ($record) {
                        $signed = $record->getSignedQuantity();
                        $unit = $record->product->unit ?? '';
                        return ($signed > 0 ? '+' : '') . $signed . ' ' . $unit;
                    })
                    ->color(fn ($record) => $record->getSignedQuantity() > 0 ? 'success' : 'danger')
                    ->weight('bold')
                    ->sortable(),

                TextColumn::make('notes')
                    ->label('Keterangan')
                    ->searchable()
                    ->placeholder('—')
                    ->wrap(),

                TextColumn::make('user.name')
                    ->label('Petugas')
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
                    ->label('Tipe Penyesuaian')
                    ->options([
                        'waste' => 'Waste (Penyusutan)',
                        'damage' => 'Barang Rusak',
                        'correction_add' => 'Koreksi Tambah',
                        'correction_sub' => 'Koreksi Kurang',
                    ]),

                Filter::make('adjusted_at_range')
                    ->form([
                        DatePicker::make('from')->label('Dari Tanggal'),
                        DatePicker::make('until')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn (Builder $q, $d) => $q->whereDate('adjusted_at', '>=', $d))
                            ->when($data['until'], fn (Builder $q, $d) => $q->whereDate('adjusted_at', '<=', $d));
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
                DeleteAction::make()
                    ->label('Hapus')
                    ->icon('heroicon-o-trash'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->paginated([10, 25, 50, 100]);
    }
}
