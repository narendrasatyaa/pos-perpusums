<?php

namespace App\Filament\Resources\StockInbound\Schemas;

use App\Models\Product;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class StockInboundForm
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
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $product = Product::find($state);
                            if ($product) {
                                $costPrice = $product->is_consignment 
                                    ? ($product->consignor_share_type === 'nominal' 
                                        ? $product->consignor_share 
                                        : intval(intdiv($product->price * $product->consignor_share, 100)))
                                    : $product->cost_price;

                                $set('cost_price', $costPrice ?? 0);
                            }
                        }
                    }),

                TextInput::make('quantity')
                    ->label('Jumlah Masuk')
                    ->numeric()
                    ->minValue(1)
                    ->required(),

                TextInput::make('cost_price')
                    ->label('Harga Modal / Unit (Supplier)')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                TextInput::make('supplier')
                    ->label('Nama Supplier')
                    ->placeholder('Contoh: PT. Biji Kopi Abadi')
                    ->maxLength(255),

                DatePicker::make('received_at')
                    ->label('Tanggal Terima')
                    ->default(now())
                    ->required(),

                Textarea::make('notes')
                    ->label('Catatan Keterangan')
                    ->placeholder('Keterangan opsional...')
                    ->columnSpanFull()
                    ->maxLength(65535),
            ]);
    }
}
