<?php

namespace App\Filament\Pages;

use App\Models\Category;
use App\Models\Product;
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

class TopProduk extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-trophy';
    protected string $view = 'filament.pages.top-produk';
    protected static ?string $title = 'Top Produk Terlaris';
    protected static ?string $navigationLabel = 'Top Produk';
    protected static \UnitEnum|string|null $navigationGroup = 'Laporan Penjualan';
    protected static ?int $navigationSort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->select('products.id', 'products.name', 'products.category_id', 'products.price')
                    ->selectRaw('COALESCE(SUM(transaction_items.quantity), 0) as total_qty')
                    ->selectRaw('COALESCE(SUM(transaction_items.subtotal), 0) as total_revenue')
                    ->selectRaw('COUNT(DISTINCT transaction_items.transaction_id) as transaction_count')
                    ->join('transaction_items', DB::raw('CAST(products.id AS CHAR)'), '=', 'transaction_items.product_id')
                    ->join('transactions', function ($join) {
                        $join->on('transaction_items.transaction_id', '=', 'transactions.id')
                             ->where('transactions.status', '=', 'paid');
                    })
                    ->groupBy('products.id', 'products.name', 'products.category_id', 'products.price')
                    ->orderByDesc('total_qty')
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Produk')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('total_qty')
                    ->label('Qty Terjual')
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->summarize(Sum::make()->label('Total')),

                TextColumn::make('total_revenue')
                    ->label('Revenue')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold')
                    ->color('success')
                    ->summarize(Sum::make()->money('IDR')->label('Total')),

                TextColumn::make('transaction_count')
                    ->label('Jumlah Transaksi')
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Harga Satuan')
                    ->money('IDR')
                    ->toggleable(isToggledHiddenByDefault: true),
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
                    ->label('Kategori')
                    ->options(fn () => Category::where('is_active', true)->pluck('name', 'id')->toArray())
                    ->searchable()
                    ->preload()
                    ->query(fn (Builder $query, array $data) => $query->when($data['value'], fn ($q, $v) => $q->where('products.category_id', $v))),
            ])
            ->paginated([10, 25, 50]);
    }
}
