<?php

namespace App\Filament\Resources\MediaObjectResource\Pages;

use App\Filament\Resources\MediaObjectResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMediaObjects extends ListRecords
{
    protected static string $resource = MediaObjectResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
