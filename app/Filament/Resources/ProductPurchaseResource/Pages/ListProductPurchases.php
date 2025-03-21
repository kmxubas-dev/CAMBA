<?php

namespace App\Filament\Resources\ProductPurchaseResource\Pages;

use App\Filament\Resources\ProductPurchaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductPurchases extends ListRecords
{
    protected static string $resource = ProductPurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
