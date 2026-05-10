<?php

namespace App\Filament\Resources\Vouchers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VouchersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Kode')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('discount_type')
                    ->label('Tipe')
                    ->formatStateUsing(fn (string $state): string => $state === 'percent' ? 'Persentase' : 'Nominal')
                    ->badge(),
                TextColumn::make('discount_value')
                    ->label('Nilai')
                    ->formatStateUsing(function (int $state, $record): string {
                        if ($record->discount_type === 'percent') {
                            return $state . '%';
                        }

                        return 'Rp ' . number_format($state, 0, ',', '.');
                    }),
                TextColumn::make('min_purchase')
                    ->label('Min. Belanja')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('used_count')
                    ->label('Terpakai')
                    ->formatStateUsing(fn (int $state, $record): string => $record->usage_limit ? $state . ' / ' . $record->usage_limit : (string) $state),
                TextColumn::make('expires_at')
                    ->label('Kadaluarsa')
                    ->dateTime(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
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
            ]);
    }
}
