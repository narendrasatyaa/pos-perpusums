<?php

namespace App\Filament\Resources\ActivityLogs;

use App\Filament\Resources\ActivityLogs\Pages;
use App\Models\ActivityLog;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Actions\ViewAction;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\KeyValueEntry;
use Illuminate\Database\Eloquent\Builder;

class ActivityLogResource extends Resource
{
    protected static ?string $model = ActivityLog::class;

    protected static ?string $modelLabel = 'Log Aktivitas';
    protected static ?string $pluralModelLabel = 'Log Aktivitas';
    protected static ?string $navigationLabel = 'Log Aktivitas';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';
    // Kelompok menu di sidebar
    protected static \UnitEnum|string|null $navigationGroup = 'Log Aktivitas';

    protected static ?int $navigationSort = 99;

    // Menonaktifkan pembuatan log secara manual dari UI
    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Pengguna')
                    ->placeholder('System')
                    ->searchable(),
                TextColumn::make('action')
                    ->label('Aktivitas')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'create' => 'success',
                        'update' => 'warning',
                        'delete' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('module')
                    ->label('Modul')
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                // Filter berdasarkan Pengguna
                SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Pengguna'),

                // Filter berdasarkan Modul
                SelectFilter::make('module')
                    ->options([
                        'Product' => 'Product',
                        'User' => 'User',
                        'StockInbound' => 'Stock Inbound',
                        'StockAdjustment' => 'Stock Adjustment',
                        'Transaction' => 'Transaction',
                    ])
                    ->label('Modul'),

                // Filter Rentang Tanggal
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')->label('Dari Tanggal'),
                        DatePicker::make('created_until')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                // Tombol Lihat Detail
                ViewAction::make()->label('Lihat Detail'),
            ])
            ->bulkActions([]); // Kosongkan agar tidak bisa bulk delete
    }

    // Mengatur tampilan detail log saat tombol "Lihat Detail" diklik
    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')->label('Pengguna')->placeholder('System'),
                TextEntry::make('action')->label('Aktivitas'),
            TextEntry::make('module')->label('Modul'),
            // TextEntry::make('ip_address')->label('Alamat IP'),
            TextEntry::make('description')->label('Deskripsi')->columnSpanFull(),
            KeyValueEntry::make('old_values')
                ->label('Nilai Sebelum Perubahan')
                ->columnSpan(1),
            KeyValueEntry::make('new_values')
                ->label('Nilai Sesudah Perubahan')
                ->columnSpan(1),
            TextEntry::make('created_at')->label('Waktu')->dateTime(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
        ];
    }
}
