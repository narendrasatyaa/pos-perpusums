<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CashFlow\Pages\CreateCashFlow;
use App\Filament\Resources\CashFlow\Pages\EditCashFlow;
use App\Filament\Resources\CashFlow\Pages\ListCashFlows;
use App\Filament\Resources\CashFlow\Schemas\CashFlowForm;
use App\Filament\Resources\CashFlow\Tables\CashFlowTable;
use App\Models\CashFlow;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class CashFlowResource extends Resource
{
    protected static ?string $model = CashFlow::class;

    protected static ?string $modelLabel = 'Pemasukan & Pengeluaran';
    protected static ?string $pluralModelLabel = 'Pemasukan & Pengeluaran';
    protected static ?string $navigationLabel = 'Pemasukan & Pengeluaran';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';
    protected static \UnitEnum|string|null $navigationGroup = 'Keuangan & Kas';
    protected static ?int $navigationSort = 1;

    public static function canViewAny(): bool
    {
        return in_array(auth()->user()?->role, [User::ROLE_ADMIN, User::ROLE_FINANCE]);
    }

    public static function form(Schema $schema): Schema
    {
        return CashFlowForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CashFlowTable::configure($table);
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
            'index' => ListCashFlows::route('/'),
            'create' => CreateCashFlow::route('/create'),
            'edit' => EditCashFlow::route('/{record}/edit'),
        ];
    }
}
