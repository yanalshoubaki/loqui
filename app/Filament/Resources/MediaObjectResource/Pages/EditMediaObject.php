<?php

namespace App\Filament\Resources\MediaObjectResource\Pages;

use App\Filament\Resources\MediaObjectResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMediaObject extends EditRecord
{
    protected static string $resource = MediaObjectResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
