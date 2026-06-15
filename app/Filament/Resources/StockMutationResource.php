<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockMutation\Pages\ListStockMutations;
use App\Models\StockMutation;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class StockMutationResource extends Resource
{
    protected static ?string $model = StockMutation::class;

    protected static ?string $modelLabel = 'Log Mutasi Stok';
    protected static ?string $pluralModelLabel = 'Log Mutasi Stok';
    protected static ?string $navigationLabel = 'Log Mutasi Stok';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-queue-list';
    protected static \UnitEnum|string|null $navigationGroup = 'Manajemen Stok';
    protected static ?int $navigationSort = 4;

    public static function canViewAny(): bool
    {
        return in_array(auth()->user()?->role, [User::ROLE_ADMIN, User::ROLE_FINANCE]);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema; // No form needed for read-only log
    }

    public static function table(Table $table): Table
    {
        // Custom table configuration is handled in a separate class or directly here
        return \App\Filament\Resources\StockMutation\Tables\StockMutationTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStockMutations::route('/'),
        ];
    }
}
