<?php

namespace App\Filament\Resources\CashFlow\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CashFlowForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('Tipe Kas')
                    ->options([
                        'in' => 'Pemasukan (Cash In)',
                        'out' => 'Pengeluaran (Expense)',
                    ])
                    ->required()
                    ->live(),

                Select::make('category')
                    ->label('Kategori')
                    ->options(fn (callable $get) => match ($get('type')) {
                        'in' => [
                            'modal' => 'Setor Modal',
                            'lain_lain' => 'Pemasukan Lain-lain',
                        ],
                        'out' => [
                            'bahan_baku' => 'Bahan Baku',
                            'gaji' => 'Gaji Karyawan',
                            'operasional' => 'Operasional Kafe (Listrik, Wifi, dll)',
                            'lain_lain' => 'Pengeluaran Lain-lain',
                        ],
                        default => [],
                    })
                    ->required()
                    ->disabled(fn (callable $get) => blank($get('type'))),

                TextInput::make('amount')
                    ->label('Nominal')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                DatePicker::make('transaction_date')
                    ->label('Tanggal Transaksi')
                    ->default(now())
                    ->required(),

                Textarea::make('description')
                    ->label('Catatan / Keterangan')
                    ->placeholder('Keterangan singkat mengenai transaksi...')
                    ->columnSpanFull()
                    ->maxLength(65535),
            ]);
    }
}
