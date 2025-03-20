<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductAuctionResource\Pages;
use App\Filament\Resources\ProductAuctionResource\RelationManagers;
use App\Models\ProductAuction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductAuctionResource extends Resource
{
    protected static ?string $model = ProductAuction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('images')
                    ->label('Artwork')
                    ->getStateUsing(function ($record) {
                        return asset($record->product->images);
                    })
                    ->height(50)
                    ->width(50)
                    ->circular(),
                TextColumn::make('name')
                    ->label('Name')
                    ->getStateUsing(function ($record) {
                        return $record->product->name;
                    }),
                TextColumn::make('price')
                    ->label('Starting Bid')
                    ->money('PHP')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListProductAuctions::route('/'),
            'create' => Pages\CreateProductAuction::route('/create'),
            'view' => Pages\ViewProductAuction::route('/{record}'),
            'edit' => Pages\EditProductAuction::route('/{record}/edit'),
        ];
    }

    // -------------------------------------------------------------------------------- //

    public static function getLabel(): string
    {
        return 'Auction';
    }
    
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ImageEntry::make('images')
                    ->label('Artwork')
                    ->getStateUsing(function ($record) {
                        return asset($record->product->images);
                    })
                    ->height(200),
                TextEntry::make('status'),
                TextEntry::make('name')
                    ->label('Name')
                    ->getStateUsing(function ($record) {
                        return $record->product->name;
                    }),
                TextEntry::make('price')->label('Starting Bid')->money('PHP'),
                TextEntry::make('start')->dateTime(),
                TextEntry::make('end')->dateTime(),
                TextEntry::make('price')
                    ->label('Winning Bid')
                    ->getStateUsing(function ($record) {
                        return $record->bids->max('amount');
                    })
                    ->money('PHP'),
            ]);
    }
}
