<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockInbound\Pages\CreateStockInbound;
use App\Filament\Resources\StockInbound\Pages\EditStockInbound;
use App\Filament\Resources\StockInbound\Pages\ListStockInbounds;
use App\Filament\Resources\StockInbound\Schemas\StockInboundForm;
use App\Filament\Resources\StockInbound\Tables\StockInboundTable;
use App\Models\StockInbound;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class StockInboundResource extends Resource
{
    protected static ?string $model = StockInbound::class;

    protected static ?string $modelLabel = 'Stok Masuk';
    protected static ?string $pluralModelLabel = 'Stok Masuk';
    protected static ?string $navigationLabel = 'Stok Masuk';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-left-end-on-rectangle';
    protected static \UnitEnum|string|null $navigationGroup = 'Manajemen Stok';
    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        return in_array(auth()->user()?->role, [User::ROLE_ADMIN, User::ROLE_FINANCE]);
    }

    public static function form(Schema $schema): Schema
    {
        return StockInboundForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StockInboundTable::configure($table);
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
            'index' => ListStockInbounds::route('/'),
            'create' => CreateStockInbound::route('/create'),
            'edit' => EditStockInbound::route('/{record}/edit'),
        ];
    }
}
