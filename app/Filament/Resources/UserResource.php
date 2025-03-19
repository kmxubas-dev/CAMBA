<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
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

class UserResource extends Resource
{
    protected static ?string $model = User::class;

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
                TextColumn::make('id'),
                ImageColumn::make('profile_photo_path')
                    ->label('Profile')
                    ->getStateUsing(function ($record) {
                        return asset($record->profile_photo_path);
                    })
                    ->height(50)
                    ->width(50)
                    ->circular()
                    ->default(asset('assets/img/placeholders/profile.png')),
                TextColumn::make('fname')->label('First Name')->sortable()->searchable(),
                TextColumn::make('lname')->label('Last Name')->sortable()->searchable(),
                TextColumn::make('email')->sortable()->searchable(),
                TextColumn::make('type')->sortable()->searchable(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    // -------------------------------------------------------------------------------- //
    
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ImageEntry::make('profile_photo_path')
                    ->label('Profile')
                    ->getStateUsing(function ($record) {
                        return asset($record->profile_photo_path);
                    })
                    ->height(100)
                    ->width(100)
                    ->circular()
                    ->default(asset('assets/img/placeholders/profile.png')),
                TextEntry::make(''),
                TextEntry::make('name'),
                TextEntry::make('email'),
                TextEntry::make('type')->label('User Type'),
                TextEntry::make('created_at')->label('Joined')->dateTime(),
                TextEntry::make('email_verified_at')->label('Verified')->dateTime(),
            ]);
    }
}
