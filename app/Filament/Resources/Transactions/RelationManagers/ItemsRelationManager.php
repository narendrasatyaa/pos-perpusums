<?php

namespace App\Filament\Resources\Transactions\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';
    protected static ?string $title = 'Detail Item';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product_name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn ($record) => $record->selected_options 
                        ? implode(', ', array_values($record->selected_options)) 
                        : null),

                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR'),

                TextColumn::make('quantity')
                    ->label('Qty')
                    ->badge()
                    ->color('info'),

                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('IDR')
                    ->weight('bold')
                    ->color('success'),
            ])
            ->paginated(false);
    }
}
