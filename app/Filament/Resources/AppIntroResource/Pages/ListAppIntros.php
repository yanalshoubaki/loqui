<?php

namespace App\Filament\Resources\AppIntroResource\Pages;

use App\Filament\Resources\AppIntroResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAppIntros extends ListRecords
{
    protected static string $resource = AppIntroResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
