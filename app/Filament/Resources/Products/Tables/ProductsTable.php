<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('price')
                    ->label('Harga Jual')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('cost_price')
                    ->label('HPP')
                    ->money('IDR')
                    ->getStateUsing(fn ($record) => $record->is_consignment 
                        ? ($record->consignor_share_type === 'nominal' 
                            ? $record->consignor_share 
                            : intval(intdiv($record->price * $record->consignor_share, 100)))
                        : $record->cost_price
                    )
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('is_consignment')
                    ->label('Tipe Produk')
                    ->formatStateUsing(fn ($record): string => $record->is_consignment 
                        ? 'Titipan (' . ($record->consignor_share_type === 'nominal' 
                            ? 'Rp ' . number_format($record->consignor_share, 0, ',', '.') 
                            : $record->consignor_share . '%') . ')' 
                        : 'Normal'
                    )
                    ->badge()
                    ->color(fn ($record): string => $record->is_consignment ? 'warning' : 'info')
                    ->sortable(),
                TextColumn::make('stock')
                    ->numeric()
                    ->sortable()
                    ->label('Stok')
                    ->badge()
                    ->color(fn ($state, $record): string => match (true) {
                        $state == 0 => 'danger',
                        $state <= $record->min_stock => 'warning',
                        default => 'success',
                    }),
                TextColumn::make('unit')
                    ->label('Satuan')
                    ->sortable(),
                IconColumn::make('is_available')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // EditAction::make(),
                EditAction::make()
                    ->label('Ubah')
                    ->icon('heroicon-o-pencil'),
                ViewAction::make()
                    ->label('Lihat')
                    ->icon('heroicon-o-eye'),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->paginated();
    }
}
