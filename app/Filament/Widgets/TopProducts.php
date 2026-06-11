<?php

namespace App\Filament\Widgets;

use App\Models\TransactionItem;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class TopProducts extends BaseWidget
{
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 1;
    protected static ?string $heading = 'Top 5 Produk Terlaris';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                \App\Models\Product::query()
                    ->withSum('transactionItems', 'quantity')
                    ->having('transaction_items_sum_quantity', '>', 0)
                    ->orderByDesc('transaction_items_sum_quantity')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Produk'),
                Tables\Columns\TextColumn::make('transaction_items_sum_quantity')
                    ->label('Total Terjual')
                    ->badge()
                    ->color('success'),
            ])
            ->paginated(false);
    }
}
