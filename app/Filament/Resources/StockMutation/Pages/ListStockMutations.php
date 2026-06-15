<?php

namespace App\Filament\Resources\StockMutation\Pages;

use App\Filament\Resources\StockMutationResource;
use Filament\Resources\Pages\ListRecords;

class ListStockMutations extends ListRecords
{
    protected static string $resource = StockMutationResource::class;

    protected function getHeaderActions(): array
    {
        return []; // Fully read-only log page
    }
}
