<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Kategori'),
                TextInput::make('name')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Harga Jual')
                    ->live(onBlur: true),
                TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->placeholder(0)
                    ->label('Stok'),
                TextInput::make('min_stock')
                    ->required()
                    ->numeric()
                    ->default(10)
                    ->label('Stok Minimum'),
                TextInput::make('unit')
                    ->required()
                    ->default('pcs')
                    ->placeholder('pcs, porsi, cup, dll')
                    ->label('Satuan'),
                Toggle::make('is_available')
                    ->required()
                    ->label('Tersedia'),
                Toggle::make('is_consignment')
                    ->label('Barang Titipan (Konsinyasi)')
                    ->default(false)
                    ->live(),
                Select::make('consignor_share_type')
                    ->label('Tipe Bagi Hasil')
                    ->options([
                        'percent' => 'Persentase (%)',
                        'nominal' => 'Nominal Rupiah (Rp)',
                    ])
                    ->default('percent')
                    ->live()
                    ->visible(fn (callable $get) => $get('is_consignment'))
                    ->required(fn (callable $get) => $get('is_consignment')),
                TextInput::make('cost_price')
                    ->label('Harga Pokok (HPP)')
                    ->numeric()
                    ->prefix('Rp')
                    ->placeholder('Kosongkan jika barang titipan')
                    ->required(fn (callable $get) => !$get('is_consignment'))
                    ->disabled(fn (callable $get) => $get('is_consignment'))
                    ->dehydrated(fn ($state) => filled($state))
                    ->live(onBlur: true),
                TextInput::make('consignor_share')
                    ->label(fn (callable $get) => $get('consignor_share_type') === 'nominal' ? 'Harga dari Penitip' : 'Persentase Penitip')
                    ->numeric()
                    ->prefix(fn (callable $get) => $get('consignor_share_type') === 'nominal' ? 'Rp' : null)
                    ->suffix(fn (callable $get) => $get('consignor_share_type') === 'percent' ? '%' : null)
                    ->minValue(0)
                    ->maxValue(fn (callable $get) => $get('consignor_share_type') === 'percent' ? 100 : null)
                    ->required(fn (callable $get) => $get('is_consignment'))
                    ->visible(fn (callable $get) => $get('is_consignment'))
                    ->live(onBlur: true),
                Placeholder::make('estimated_profit')
                    ->label('Estimasi Keuntungan')
                    ->content(function (callable $get) {
                        $price = floatval($get('price'));
                        $isConsignment = $get('is_consignment');

                        if (!$price) {
                            return new HtmlString('<span class="text-gray-500 italic">Harap masukkan Harga Jual terlebih dahulu</span>');
                        }

                        if ($isConsignment) {
                            $consignorShareType = $get('consignor_share_type');
                            $consignorShare = floatval($get('consignor_share'));

                            if ($consignorShareType === 'nominal') {
                                $profit = $price - $consignorShare;
                            } else {
                                $profit = $price * (100 - $consignorShare) / 100;
                            }
                        } else {
                            $costPrice = floatval($get('cost_price'));
                            $profit = $price - $costPrice;
                        }

                        $percentage = $price > 0 ? ($profit / $price) * 100 : 0;

                        $colorClass = $profit >= 0 ? 'text-success-600 dark:text-success-400' : 'text-danger-600 dark:text-danger-400';
                        $formattedProfit = 'Rp ' . number_format($profit, 0, ',', '.');
                        $formattedPercentage = number_format($percentage, 2, ',', '.') . '%';

                        return new HtmlString(
                            "<span class='text-lg font-bold {$colorClass}'>{$formattedProfit} ({$formattedPercentage})</span>"
                        );
                    }),
            ]);
    }
}
