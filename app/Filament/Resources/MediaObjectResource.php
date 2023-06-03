<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaObjectResource\Pages;
use App\Models\MediaObject;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class MediaObjectResource extends Resource
{
    protected static ?string $model = MediaObject::class;

    protected static ?string $navigationIcon = 'heroicon-o-photograph';


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('media_path')->label('Image')->rounded(),
                Tables\Columns\TextColumn::make('media_type')->sortable(),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMediaObjects::route('/')
        ];
    }
}
