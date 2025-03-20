<?php

namespace App\Filament\Resources\ProductAuctionResource\Pages;

use App\Filament\Resources\ProductAuctionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductAuctions extends ListRecords
{
    protected static string $resource = ProductAuctionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
