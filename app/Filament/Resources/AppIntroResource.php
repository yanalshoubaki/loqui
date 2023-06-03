<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppIntroResource\Pages;
use App\Filament\Resources\AppIntroResource\RelationManagers;
use App\Models\AppIntro;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppIntroResource extends Resource
{
    protected static ?string $model = AppIntro::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal information') ->schema([
                    Forms\Components\TextInput::make('intro_title')
                        ->required(),
                    Forms\Components\TextInput::make('intro_description')
                        ->required(),
                    Forms\Components\FileUpload::make('mediaObjects.media_path')->required()
                ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('mediaObject.media_path')->label('Image')->square(),
                Tables\Columns\TextColumn::make('intro_title')->sortable(),
                Tables\Columns\TextColumn::make('intro_description')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListAppIntros::route('/'),
            'create' => Pages\CreateAppIntro::route('/create'),
            'edit' => Pages\EditAppIntro::route('/{record}/edit'),
        ];
    }
}
