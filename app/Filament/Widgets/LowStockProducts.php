<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LowStockProducts extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 2;
    protected static ?string $heading = 'Produk Stok Menipis';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->whereColumn('stock', '<=', 'min_stock')
                    ->orderBy('stock', 'asc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stok Tersisa')
                    ->formatStateUsing(fn ($state, $record) => $state . ' ' . $record->unit)
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        intval($state) == 0 => 'danger',
                        default => 'warning',
                    }),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR'),
            ])
            ->paginated();
    }
}
