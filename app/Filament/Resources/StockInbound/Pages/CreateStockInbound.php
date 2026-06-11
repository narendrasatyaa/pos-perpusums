<?php

namespace App\Filament\Resources\StockInbound\Pages;

use App\Filament\Resources\StockInboundResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStockInbound extends CreateRecord
{
    protected static string $resource = StockInboundResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
