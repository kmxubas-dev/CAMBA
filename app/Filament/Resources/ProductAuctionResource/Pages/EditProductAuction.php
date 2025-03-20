<?php

namespace App\Filament\Resources\ProductAuctionResource\Pages;

use App\Filament\Resources\ProductAuctionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductAuction extends EditRecord
{
    protected static string $resource = ProductAuctionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
