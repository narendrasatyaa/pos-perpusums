<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Models\Category;
use App\Exports\ProductsStockExport;
use Maatwebsite\Excel\Facades\Excel;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanStok extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-chart-bar';
    protected string $view = 'filament.pages.laporan-stok';
    protected static ?string $title = 'Laporan Stok & Analisis';
    protected static ?string $navigationLabel = 'Laporan Stok';
    protected static \UnitEnum|string|null $navigationGroup = 'Laporan Penjualan';
    protected static ?int $navigationSort = 6;

    public string $activeTab = 'all';

    public function updatedActiveTab()
    {
        if (method_exists($this, 'resetTablePagination')) {
            $this->resetTablePagination();
        }
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->whereNull('deleted_at')
                    ->with('category')
                    // Add last sale date via subquery
                    ->select('products.*')
                    ->selectSub(function ($q) {
                        $q->select('transactions.paid_at')
                          ->from('transaction_items')
                          ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
                          ->whereRaw('transaction_items.product_id = CAST(products.id AS CHAR)')
                          ->where('transactions.status', 'paid')
                          ->orderByDesc('transactions.paid_at')
                          ->limit(1);
                    }, 'last_sale_at')
                    // Add 30 days sales count
                    ->withSum(['transactionItems as sales_qty_30_days' => function ($q) {
                        $q->whereHas('transaction', function ($t) {
                            $t->where('status', 'paid')
                              ->where('paid_at', '>=', now()->subDays(30));
                        });
                    }], 'quantity')
                    // Filter based on selected tab
                    ->when($this->activeTab === 'low_stock', function ($query) {
                        $query->whereColumn('stock', '<=', 'min_stock');
                    })
                    ->when($this->activeTab === 'slow_moving', function ($query) {
                        $query->where(function ($q) {
                            $q->whereRaw('(SELECT COALESCE(SUM(quantity), 0) FROM transaction_items JOIN transactions ON transaction_items.transaction_id = transactions.id WHERE transaction_items.product_id = CAST(products.id AS CHAR) AND transactions.status = "paid" AND transactions.paid_at >= ?) < 5', [now()->subDays(30)]);
                        });
                    })
                    ->when($this->activeTab === 'dead_stock', function ($query) {
                        $query->where(function ($q) {
                            $q->whereRaw('(SELECT MAX(transactions.paid_at) FROM transaction_items JOIN transactions ON transaction_items.transaction_id = transactions.id WHERE transaction_items.product_id = CAST(products.id AS CHAR) AND transactions.status = "paid") IS NULL')
                              ->orWhereRaw('(SELECT MAX(transactions.paid_at) FROM transaction_items JOIN transactions ON transaction_items.transaction_id = transactions.id WHERE transaction_items.product_id = CAST(products.id AS CHAR) AND transactions.status = "paid") < ?', [now()->subDays(60)]);
                        });
                    })
            )
            ->defaultSort('stock', 'asc')
            ->columns([
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable()
                    ->placeholder('—'),

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

                TextColumn::make('stock')
                    ->label('Stok')
                    ->formatStateUsing(fn ($state, $record) => $state . ' ' . $record->unit)
                    ->sortable()
                    ->badge()
                    ->color(fn ($state, $record): string => match (true) {
                        $state == 0 => 'danger',
                        $state <= $record->min_stock => 'warning',
                        default => 'success',
                    }),

                TextColumn::make('sales_qty_30_days')
                    ->label('Terjual (30 Hari)')
                    ->getStateUsing(fn ($record) => intval($record->sales_qty_30_days) ?: 0)
                    ->numeric()
                    ->sortable(),

                TextColumn::make('last_sale_at')
                    ->label('Penjualan Terakhir')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->placeholder('Belum pernah terjual'),

                TextColumn::make('movement_status')
                    ->label('Status Gerak')
                    ->badge()
                    ->getStateUsing(function ($record) {
                        $sales30Days = intval($record->sales_qty_30_days) ?: 0;
                        $lastSaleAt = $record->last_sale_at ? Carbon::parse($record->last_sale_at) : null;

                        if (!$lastSaleAt || $lastSaleAt->lt(now()->subDays(60))) {
                            return 'Dead Stock';
                        } elseif ($sales30Days < 5) {
                            return 'Slow Moving';
                        }
                        return 'Aktif';
                    })
                    ->color(fn ($state): string => match ($state) {
                        'Dead Stock' => 'danger',
                        'Slow Moving' => 'warning',
                        default => 'success',
                    }),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->paginated([10, 25, 50, 100]);
    }

    public function export()
    {
        $filename = match ($this->activeTab) {
            'low_stock' => 'laporan-stok-rendah-',
            'slow_moving' => 'laporan-slow-moving-',
            'dead_stock' => 'laporan-dead-stock-',
            default => 'laporan-stok-produk-',
        } . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(
            new ProductsStockExport($this->getFilteredTableQuery()),
            $filename
        );
    }

    public function getLowStockCount(): int
    {
        return Product::whereColumn('stock', '<=', 'min_stock')->whereNull('deleted_at')->count();
    }

    public function getSlowMovingCount(): int
    {
        return Product::whereNull('deleted_at')
            ->whereRaw('(SELECT COALESCE(SUM(quantity), 0) FROM transaction_items JOIN transactions ON transaction_items.transaction_id = transactions.id WHERE transaction_items.product_id = CAST(products.id AS CHAR) AND transactions.status = "paid" AND transactions.paid_at >= ?) < 5', [now()->subDays(30)])
            ->count();
    }

    public function getDeadStockCount(): int
    {
        return Product::whereNull('deleted_at')
            ->where(function ($q) {
                $q->whereRaw('(SELECT MAX(transactions.paid_at) FROM transaction_items JOIN transactions ON transaction_items.transaction_id = transactions.id WHERE transaction_items.product_id = CAST(products.id AS CHAR) AND transactions.status = "paid") IS NULL')
                  ->orWhereRaw('(SELECT MAX(transactions.paid_at) FROM transaction_items JOIN transactions ON transaction_items.transaction_id = transactions.id WHERE transaction_items.product_id = CAST(products.id AS CHAR) AND transactions.status = "paid") < ?', [now()->subDays(60)]);
            })
            ->count();
    }
}
