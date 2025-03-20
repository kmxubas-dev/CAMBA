<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
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

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

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
                        return asset($record->images);
                    })
                    ->height(50)
                    ->width(50)
                    ->circular(),
                TextColumn::make('status')->sortable()->searchable(),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('price')->sortable()->searchable()->money('PHP'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    // -------------------------------------------------------------------------------- //

    public static function getLabel(): string
    {
        return 'Artwork';
    }
    
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ImageEntry::make('images')
                    ->label('Artwork')
                    ->getStateUsing(function ($record) {
                        return asset($record->images);
                    })
                    ->height(200),
                TextEntry::make('status'),
                TextEntry::make('name'),
                TextEntry::make('price')->money('PHP'),
                TextEntry::make('attributes')
                    ->label('Year')
                    ->getStateUsing(function ($record) {
                        return $record->attributes['year'];
                    }),
                TextEntry::make('attributes')
                    ->label('Type')
                    ->getStateUsing(function ($record) {
                        return $record->attributes['type'];
                    }),
                TextEntry::make('attributes')
                    ->label('Size')
                    ->getStateUsing(function ($record) {
                        return $record->attributes['size'];
                    }),
                TextEntry::make('description'),
            ]);
    }
}
