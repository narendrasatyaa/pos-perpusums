<?php

namespace App\Filament\Resources\StockInbound\Pages;

use App\Filament\Resources\StockInboundResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStockInbounds extends ListRecords
{
    protected static string $resource = StockInboundResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
