<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockAdjustment\Pages\CreateStockAdjustment;
use App\Filament\Resources\StockAdjustment\Pages\EditStockAdjustment;
use App\Filament\Resources\StockAdjustment\Pages\ListStockAdjustments;
use App\Filament\Resources\StockAdjustment\Schemas\StockAdjustmentForm;
use App\Filament\Resources\StockAdjustment\Tables\StockAdjustmentTable;
use App\Models\StockAdjustment;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class StockAdjustmentResource extends Resource
{
    protected static ?string $model = StockAdjustment::class;

    protected static ?string $modelLabel = 'Penyesuaian Stok';
    protected static ?string $pluralModelLabel = 'Penyesuaian Stok';
    protected static ?string $navigationLabel = 'Penyesuaian Stok';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-adjustments-horizontal';
    protected static \UnitEnum|string|null $navigationGroup = 'Manajemen Stok';
    protected static ?int $navigationSort = 3;

    public static function canViewAny(): bool
    {
        return in_array(auth()->user()?->role, [User::ROLE_ADMIN, User::ROLE_FINANCE]);
    }

    public static function form(Schema $schema): Schema
    {
        return StockAdjustmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StockAdjustmentTable::configure($table);
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
            'index' => ListStockAdjustments::route('/'),
            'create' => CreateStockAdjustment::route('/create'),
            'edit' => EditStockAdjustment::route('/{record}/edit'),
        ];
    }
}
