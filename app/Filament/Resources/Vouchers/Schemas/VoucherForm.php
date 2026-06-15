<?php

namespace App\Filament\Resources\Vouchers\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VoucherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label('Kode Voucher')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignoreRecord: true)
                    ->dehydrateStateUsing(fn (?string $state): string => strtoupper(trim((string) $state))),
                TextInput::make('name')
                    ->label('Nama Voucher')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(2)
                    ->nullable(),
                Select::make('discount_type')
                    ->label('Tipe Diskon')
                    ->required()
                    ->options([
                        'percent' => 'Persentase (%)',
                        'nominal' => 'Nominal (Rp)',
                    ])
                    ->native(false)
                    ->live(),
                TextInput::make('discount_value')
                    ->label('Nilai Diskon')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(fn (callable $get) => $get('discount_type') === 'percent' ? 100 : 999999999)
                    ->maxLength(fn (callable $get) => $get('discount_type') === 'percent' ? 3 : null)
                    ->prefix(fn (callable $get) => $get('discount_type') === 'nominal' ? 'Rp' : null)
                    ->suffix(fn (callable $get) => $get('discount_type') === 'percent' ? '%' : null)
                    ->helperText('Untuk tipe Persentase, maksimal 100%.')
                    ->rules([
                        fn (callable $get) => $get('discount_type') === 'percent'
                            ? ['integer', 'max:100']
                            : ['integer'],
                    ]),
                // TextInput::make('max_discount')
                //     ->label('Maksimal Diskon (opsional)')
                //     ->numeric()
                //     ->minValue(0)
                //     ->prefix('Rp')
                //     ->nullable(),
                TextInput::make('min_purchase')
                    ->label('Minimal Belanja (opsional)')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->prefix('Rp'),
                TextInput::make('usage_limit')
                    ->label('Batas Pemakaian (opsional)')
                    ->numeric()
                    ->minValue(1)
                    ->nullable(),
                TextInput::make('used_count')
                    ->label('Sudah Dipakai')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(false),
                DateTimePicker::make('starts_at')
                    ->label('Mulai Berlaku')
                    ->seconds(false)
                    ->required(),
                DateTimePicker::make('expires_at')
                    ->label('Tanggal Kadaluarsa')
                    ->seconds(false)
                    ->required(),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->required()
                    ->default(true),
            ]);
    }
}
