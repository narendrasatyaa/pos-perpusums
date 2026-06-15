<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Models\Category;
use App\Services\AbcXyzAnalysisService;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AnalisisStok extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-trending-up';
    
    protected string $view = 'filament.pages.analisis-stok';
    protected static ?string $title = 'Analisis & Klasifikasi Stok';
    protected static ?string $navigationLabel = 'Analisis & Klasifikasi';
    protected static \UnitEnum|string|null $navigationGroup = 'Manajemen Stok';
    protected static ?int $navigationSort = 7;

    // Filter properties
    public string $timeframe = '30'; // '30', '60', '90', 'custom'
    public ?string $startDate = null;
    public ?string $endDate = null;

    // Interactive Grid filter
    public ?string $selectedClass = null; // e.g. 'AX', 'CZ'

    // ABC-XYZ Cache
    protected ?array $abcXyzData = null;

    public static function canViewAny(): bool
    {
        return in_array(auth()->user()?->role, [\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_FINANCE]);
    }

    public function mount()
    {
        $this->updateDates();
    }

    public function updatedTimeframe()
    {
        $this->updateDates();
        $this->resetTable();
    }

    public function updatedStartDate()
    {
        $this->resetTable();
    }

    public function updatedEndDate()
    {
        $this->resetTable();
    }

    protected function updateDates()
    {
        if ($this->timeframe === 'custom') {
            if (!$this->startDate) {
                $this->startDate = Carbon::now()->subDays(30)->format('Y-m-d');
            }
            if (!$this->endDate) {
                $this->endDate = Carbon::now()->format('Y-m-d');
            }
        } else {
            $days = (int) $this->timeframe;
            $this->startDate = Carbon::now()->subDays($days)->format('Y-m-d');
            $this->endDate = Carbon::now()->format('Y-m-d');
        }
    }

    protected function resetTable()
    {
        $this->abcXyzData = null;
        if (method_exists($this, 'resetTablePagination')) {
            $this->resetTablePagination();
        }
    }

    public function getAnalysisData(): array
    {
        if ($this->abcXyzData === null) {
            $service = new AbcXyzAnalysisService();
            $start = $this->startDate . ' 00:00:00';
            $end = $this->endDate . ' 23:59:59';
            $this->abcXyzData = $service->calculate($start, $end);
        }
        return $this->abcXyzData;
    }

    // Toggle interactive grid filter
    public function selectGridClass(?string $class)
    {
        if ($this->selectedClass === $class) {
            $this->selectedClass = null;
        } else {
            $this->selectedClass = $class;
        }
        $this->resetTable();
    }

    // Get count of products in each class for the matrix
    public function getMatrixCounts(): array
    {
        $data = $this->getAnalysisData();
        $counts = [
            'AX' => 0, 'AY' => 0, 'AZ' => 0,
            'BX' => 0, 'BY' => 0, 'BZ' => 0,
            'CX' => 0, 'CY' => 0, 'CZ' => 0,
        ];
        
        foreach ($data as $pId => $pData) {
            $class = $pData['abc'] . $pData['xyz'];
            if (isset($counts[$class])) {
                $counts[$class]++;
            }
        }
        
        return $counts;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->whereNull('deleted_at')
                    ->with('category')
            )
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

                TextColumn::make('stock')
                    ->label('Stok Saat Ini')
                    ->formatStateUsing(fn ($state, $record) => $state . ' ' . $record->unit)
                    ->sortable(),

                TextColumn::make('revenue')
                    ->label('Total Omzet')
                    ->money('IDR')
                    ->getStateUsing(function ($record) {
                        $analysis = $this->getAnalysisData();
                        return $analysis[(string) $record->id]['revenue'] ?? 0;
                    })
                    ->sortable(query: function ($query, $direction) {
                        $start = $this->startDate . ' 00:00:00';
                        $end = $this->endDate . ' 23:59:59';
                        return $query->select('products.*')
                            ->selectSub(function ($q) use ($start, $end) {
                                $q->select(DB::raw('COALESCE(SUM(subtotal), 0)'))
                                  ->from('transaction_items')
                                  ->join('transactions', 'transactions.id', '=', 'transaction_items.transaction_id')
                                  ->where('transactions.status', 'paid')
                                  ->whereBetween('transactions.paid_at', [$start, $end])
                                  ->whereRaw('transaction_items.product_id = CAST(products.id AS CHAR)');
                            }, 'revenue_sort')
                            ->orderBy('revenue_sort', $direction);
                    }),

                TextColumn::make('quantity_sold')
                    ->label('Qty Terjual')
                    ->getStateUsing(function ($record) {
                        $analysis = $this->getAnalysisData();
                        return $analysis[(string) $record->id]['quantity'] ?? 0;
                    })
                    ->numeric()
                    ->sortable(query: function ($query, $direction) {
                        $start = $this->startDate . ' 00:00:00';
                        $end = $this->endDate . ' 23:59:59';
                        return $query->select('products.*')
                            ->selectSub(function ($q) use ($start, $end) {
                                $q->select(DB::raw('COALESCE(SUM(quantity), 0)'))
                                  ->from('transaction_items')
                                  ->join('transactions', 'transactions.id', '=', 'transaction_items.transaction_id')
                                  ->where('transactions.status', 'paid')
                                  ->whereBetween('transactions.paid_at', [$start, $end])
                                  ->whereRaw('transaction_items.product_id = CAST(products.id AS CHAR)');
                            }, 'qty_sort')
                            ->orderBy('qty_sort', $direction);
                    }),

                TextColumn::make('abc_xyz')
                    ->label('Klasifikasi')
                    ->badge()
                    ->getStateUsing(function ($record) {
                        $analysis = $this->getAnalysisData();
                        $abc = $analysis[(string) $record->id]['abc'] ?? 'C';
                        $xyz = $analysis[(string) $record->id]['xyz'] ?? 'Z';
                        return $abc . $xyz;
                    })
                    ->color(fn ($state): string => match ($state) {
                        'AX', 'AY', 'BX' => 'success',
                        'AZ', 'BY', 'CX', 'CY' => 'warning',
                        default => 'danger',
                    }),

                TextColumn::make('recommendation')
                    ->label('Rekomendasi Kebijakan')
                    ->getStateUsing(fn ($record) => $this->getRecommendation($record))
                    ->wrap(),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                if ($this->selectedClass) {
                    $analysis = $this->getAnalysisData();
                    $matchingIds = [];
                    foreach ($analysis as $pId => $pData) {
                        $class = $pData['abc'] . $pData['xyz'];
                        if ($class === $this->selectedClass) {
                            $matchingIds[] = $pId;
                        }
                    }
                    $query->whereIn('id', $matchingIds);
                }
            })
            ->paginated([10, 25, 50, 100])
            ->headerActions([
                \Filament\Actions\Action::make('export_excel')
                    ->label('Ekspor Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(fn () => $this->exportToExcel()),
            ]);
    }

    protected function getRecommendation(Product $record): string
    {
        $analysis = $this->getAnalysisData();
        $abc = $analysis[(string) $record->id]['abc'] ?? 'C';
        $xyz = $analysis[(string) $record->id]['xyz'] ?? 'Z';
        $class = $abc . $xyz;

        return match ($class) {
            'AX' => 'Prioritas Utama: Kontrol stok ketat, safety stock rendah, reorder otomatis.',
            'AY' => 'Prioritas Utama: Kontrol stok ketat, safety stock sedang karena fluktuatif.',
            'AZ' => 'Prioritas Tinggi: Kontrol ketat, safety stock tinggi karena sangat sporadis.',
            'BX' => 'Prioritas Sedang: Kontrol berkala, order otomatis dengan safety stock rendah.',
            'BY' => 'Prioritas Sedang: Kontrol berkala, safety stock sedang.',
            'BZ' => 'Prioritas Sedang: Cek berkala, safety stock tinggi karena sporadis.',
            'CX' => 'Prioritas Rendah: Kontrol longgar, order dalam jumlah besar untuk kurangi ongkir.',
            'CY' => 'Prioritas Rendah: Kontrol longgar, sesuaikan dengan musim.',
            'CZ' => 'Prioritas Terendah: Just-In-Time (order hanya jika habis/ada pesanan), kurangi stok.',
            default => 'Kategori tidak dikenal.',
        };
    }

    public function exportToExcel()
    {
        $analysis = $this->getAnalysisData();
        $query = $this->getFilteredTableQuery();
        
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\AbcXyzAnalysisExport($query, $analysis, $this->startDate, $this->endDate),
            'analisis-abc-xyz-' . $this->startDate . '-to-' . $this->endDate . '.xlsx'
        );
    }
}
