<?php

namespace App\Filament\Resources\StockInbound\Pages;

use App\Filament\Resources\StockInboundResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStockInbound extends EditRecord
{
    protected static string $resource = StockInboundResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
