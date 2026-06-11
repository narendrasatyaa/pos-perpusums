<?php

namespace App\Filament\Pages;

use App\Models\TransactionItem;
use App\Models\Category;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Page;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class LaporanKeuntungan extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected string $view = 'filament.pages.laporan-keuntungan';
    protected static ?string $title = 'Laporan Margin & Keuntungan';
    protected static ?string $navigationLabel = 'Laporan Keuntungan';
    protected static \UnitEnum|string|null $navigationGroup = 'Laporan Penjualan';
    protected static ?int $navigationSort = 5;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                TransactionItem::query()
                    ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
                    ->leftJoin('products', DB::raw('CAST(products.id AS CHAR)'), '=', 'transaction_items.product_id')
                    ->where('transactions.status', 'paid')
                    ->select('transaction_items.*')
                    ->selectRaw('transactions.paid_at as transaction_paid_at')
                    ->selectRaw('transactions.order_code as transaction_order_code')
                    ->selectRaw('products.is_consignment as is_consignment')
                    ->selectRaw('products.consignor_share as consignor_share')
                    ->selectRaw('products.consignor_share_type as consignor_share_type')
                    ->selectRaw('
                        CASE 
                            WHEN transaction_items.cost_price IS NOT NULL THEN
                                transaction_items.subtotal - (transaction_items.cost_price * transaction_items.quantity)
                            WHEN products.is_consignment = 1 THEN 
                                CASE 
                                    WHEN products.consignor_share_type = \'nominal\' THEN
                                        transaction_items.subtotal - (COALESCE(products.consignor_share, 0) * transaction_items.quantity)
                                    ELSE
                                        FLOOR(transaction_items.subtotal * (100 - COALESCE(products.consignor_share, 0)) / 100)
                                END
                            ELSE 
                                transaction_items.subtotal - (COALESCE(products.cost_price, 0) * transaction_items.quantity)
                        END as profit
                    ')
            )
            ->defaultSort('transactions.paid_at', 'desc')
            ->columns([
                TextColumn::make('transaction_paid_at')
                    ->label('Waktu Bayar')
                    ->dateTime('d M Y, H:i')
                    ->sortable(query: fn ($query, $direction) => $query->orderBy('transactions.paid_at', $direction)),

                TextColumn::make('transaction_order_code')
                    ->label('Kode Order')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where('transactions.order_code', 'like', "%{$search}%");
                    })
                    ->sortable(query: fn ($query, $direction) => $query->orderBy('transactions.order_code', $direction))
                    ->weight('bold'),

                TextColumn::make('product_name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('is_consignment')
                    ->label('Tipe')
                    ->formatStateUsing(fn ($record): string => $record->is_consignment 
                        ? 'Titipan (' . ($record->consignor_share_type === 'nominal'
                            ? 'Rp ' . number_format($record->consignor_share, 0, ',', '.')
                            : $record->consignor_share . '%') . ')' 
                        : 'Normal'
                    )
                    ->badge()
                    ->color(fn ($record): string => $record->is_consignment ? 'warning' : 'info')
                    ->sortable(query: fn ($query, $direction) => $query->orderBy('products.is_consignment', $direction)),

                TextColumn::make('quantity')
                    ->label('Qty')
                    ->numeric()
                    ->sortable()
                    ->summarize(Sum::make()->label('Total Qty')),

                TextColumn::make('price')
                    ->label('Harga Jual')
                    ->money('IDR')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('subtotal')
                    ->label('Total Jual')
                    ->money('IDR')
                    ->sortable()
                    ->summarize(Sum::make()->money('IDR')->label('Total Omzet')),

                TextColumn::make('cost_price')
                    ->label('HPP / Unit')
                    ->money('IDR')
                    ->getStateUsing(function ($record) {
                        if ($record->cost_price !== null) {
                            return $record->cost_price;
                        }
                        if ($record->product) {
                            if ($record->product->is_consignment) {
                                if ($record->product->consignor_share_type === 'nominal') {
                                    return $record->product->consignor_share;
                                } else {
                                    $share = intval($record->product->consignor_share) ?: 0;
                                    return intval(intdiv(intval($record->price) * $share, 100));
                                }
                            }
                            return $record->product->cost_price;
                        }
                        return null;
                    })
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('profit')
                    ->label('Keuntungan')
                    ->money('IDR')
                    ->sortable(query: function ($query, $direction) {
                        return $query->orderByRaw('
                            CASE 
                                WHEN transaction_items.cost_price IS NOT NULL THEN
                                    transaction_items.subtotal - (transaction_items.cost_price * transaction_items.quantity)
                                WHEN products.is_consignment = 1 THEN 
                                    CASE 
                                        WHEN products.consignor_share_type = \'nominal\' THEN
                                            transaction_items.subtotal - (COALESCE(products.consignor_share, 0) * transaction_items.quantity)
                                        ELSE
                                            FLOOR(transaction_items.subtotal * (100 - COALESCE(products.consignor_share, 0)) / 100)
                                    END
                                ELSE 
                                    transaction_items.subtotal - (COALESCE(products.cost_price, 0) * transaction_items.quantity)
                            END ' . $direction
                        );
                    })
                    ->weight('bold')
                    ->color('success')
                    ->summarize(Sum::make()->money('IDR')->label('Total Untung')),
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

                SelectFilter::make('category_id')
                    ->label('Kategori Produk')
                    ->options(fn () => Category::where('is_active', true)->pluck('name', 'id')->toArray())
                    ->searchable()
                    ->preload()
                    ->query(fn (Builder $query, array $data) => $query->when($data['value'], function ($q, $v) {
                        $q->whereHas('product', fn($qp) => $qp->where('category_id', $v));
                    })),
            ])
            ->paginated([10, 25, 50, 100]);
    }
}
