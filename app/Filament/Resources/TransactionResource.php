<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-receipt-percent';
    
    protected static \UnitEnum|string|null $navigationGroup = 'Riwayat & Laporan';
    protected static ?string $navigationLabel = 'Riwayat Transaksi';
    protected static ?string $modelLabel = 'Transaksi';
    protected static ?string $pluralModelLabel = 'Riwayat Transaksi';
    
    public static function canCreate(): bool
    {
        return false; // Disable creation from admin panel
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Nomor')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('secondary'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Kasir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Metode')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'cash' => 'success',
                        'qris' => 'info',
                        'transfer' => 'warning',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn (string $state) => strtoupper($state)),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total Pembayaran')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_validation_status')
                    ->label('Validasi')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'valid' => 'success',
                        'invalid' => 'danger',
                        'pending' => 'warning',
                        default => 'success', // For cash it might be null, but let's assume valid
                    })
                    ->formatStateUsing(fn (?string $state, $record) => $record->payment_method === 'cash' ? 'Cash' : ucfirst($state ?? 'Pending')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                // Add filters if requested later
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Detail'),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Infolists\Components\Section::make('Informasi Pesanan')
                    ->schema([
                        Infolists\Components\TextEntry::make('id')->label('Nomor Pesanan'),
                        Infolists\Components\TextEntry::make('user.name')->label('Kasir yang Bertugas'),
                        Infolists\Components\TextEntry::make('created_at')->label('Waktu Transaksi')->dateTime('d F Y, H:i:s WIB'),
                        Infolists\Components\TextEntry::make('payment_method')->label('Metode Pembayaran')->formatStateUsing(fn($state) => strtoupper($state)),
                        Infolists\Components\TextEntry::make('payment_validation_status')->label('Status Validasi Pembayaran')->badge()->color(fn (?string $state): string => match ($state) {
                            'valid' => 'success',
                            'invalid' => 'danger',
                            'pending' => 'warning',
                            default => 'secondary',
                        })->visible(fn($record) => in_array($record->payment_method, ['qris', 'transfer'])),
                    ])->columns(2),

                Infolists\Components\Section::make('Rincian Item')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('items')
                            ->label('')
                            ->schema([
                                Infolists\Components\TextEntry::make('product_name')->label('Menu'),
                                Infolists\Components\TextEntry::make('price')->label('Harga Satuan')->money('IDR'),
                                Infolists\Components\TextEntry::make('quantity')->label('Kuantitas'),
                                Infolists\Components\TextEntry::make('subtotal')->label('Subtotal')->money('IDR'),
                            ])
                            ->columns(4),
                    ]),

                Infolists\Components\Section::make('Rincian Pembayaran')
                    ->schema([
                        Infolists\Components\TextEntry::make('subtotal')->label('Subtotal Pesanan')->money('IDR'),
                        Infolists\Components\TextEntry::make('discount_value')->label('Diskon')->money('IDR')->visible(fn($record) => $record->discount_value > 0),
                        Infolists\Components\TextEntry::make('total')->label('Total Akhir')->money('IDR')->weight('bold'),
                        Infolists\Components\TextEntry::make('paid_amount')->label('Jumlah Dibayar (Cash)')->money('IDR')->visible(fn($record) => $record->payment_method === 'cash'),
                        Infolists\Components\TextEntry::make('change_amount')->label('Kembalian')->money('IDR')->visible(fn($record) => $record->payment_method === 'cash'),
                    ])->columns(3),
                    
                Infolists\Components\Section::make('Bukti Pembayaran')
                    ->schema([
                        Infolists\Components\ImageEntry::make('transfer_proof_path')
                            ->label('')
                    ])
                    ->visible(fn($record) => !empty($record->transfer_proof_path)),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'view' => Pages\ViewTransaction::route('/{record}'),
        ];
    }
}
