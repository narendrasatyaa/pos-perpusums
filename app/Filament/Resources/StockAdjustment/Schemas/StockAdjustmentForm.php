<?php

namespace App\Filament\Resources\StockAdjustment\Schemas;

use App\Models\Product;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class StockAdjustmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_id')
                    ->label('Produk')
                    ->options(fn () => Product::whereNull('deleted_at')
                        ->pluck('name', 'id')
                        ->toArray()
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('type')
                    ->label('Tipe Penyesuaian')
                    ->options([
                        'waste' => 'Waste (Penyusutan/Terbuang)',
                        'damage' => 'Barang Rusak',
                        'correction_add' => 'Koreksi Tambah (+)',
                        'correction_sub' => 'Koreksi Kurang (-)',
                    ])
                    ->required(),

                TextInput::make('quantity')
                    ->label('Jumlah / Qty')
                    ->numeric()
                    ->minValue(1)
                    ->required(),

                DatePicker::make('adjusted_at')
                    ->label('Tanggal Penyesuaian')
                    ->default(now())
                    ->required(),

                Textarea::make('notes')
                    ->label('Catatan / Keterangan')
                    ->placeholder('Contoh: Rusak digigit tikus, selisih opname bulanan, dll.')
                    ->columnSpanFull()
                    ->maxLength(65535),
            ]);
    }
}
