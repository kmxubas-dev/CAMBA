<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductPurchaseResource\Pages;
use App\Filament\Resources\ProductPurchaseResource\RelationManagers;
use App\Models\ProductPurchase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductPurchaseResource extends Resource
{
    protected static ?string $model = ProductPurchase::class;

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
                TextColumn::make('code')
                    ->label('Code')
                    ->getStateUsing(function ($record) {
                        return '#'.$record->purchase_info['code'];
                    }),
                TextColumn::make('status')->sortable()->searchable(),
                TextColumn::make('amount')->sortable()->searchable()->money('PHP'),
                TextColumn::make('method')
                    ->label('Method')
                    ->getStateUsing(function ($record) {
                        return $record->payment_info['method'];
                    }),
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
            ])
            ->headerActions([
                Action::make('exportMonthly')
                    ->label('Export Monthly')
                    ->url(route('export.purchases.monthly'))
                    ->icon('heroicon-o-chart-bar'),
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
            'index' => Pages\ListProductPurchases::route('/'),
            'create' => Pages\CreateProductPurchase::route('/create'),
            'view' => Pages\ViewProductPurchase::route('/{record}'),
            'edit' => Pages\EditProductPurchase::route('/{record}/edit'),
        ];
    }

    // -------------------------------------------------------------------------------- //

    public static function getLabel(): string
    {
        return 'Transaction';
    }
    
    public static function infolist(Infolist     $infolist): Infolist
    {
        return $infolist
            ->schema([
                ImageEntry::make('images')
                    ->label('Artwork')
                    ->getStateUsing(function ($record) {
                        return asset($record->product->images);
                    })
                    ->height(200),
                TextEntry::make('code')
                    ->label('Purchase ID')
                    ->getStateUsing(function ($record) {
                        return '#'.$record->purchase_info['code'];
                    }),
                TextEntry::make('name')
                    ->label('Name')
                    ->getStateUsing(function ($record) {
                        return $record->product->name;
                    }),
                TextEntry::make('status'),
                TextEntry::make('amount')->money('PHP'),
                TextEntry::make('method')
                    ->label('Method')
                    ->getStateUsing(function ($record) {
                        return $record->payment_info['method'];
                    }),
                TextEntry::make('created_at')->label('Transaction Made')->dateTime(),
            ]);
    }
}
