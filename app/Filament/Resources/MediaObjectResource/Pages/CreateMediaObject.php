<?php

namespace App\Filament\Resources\MediaObjectResource\Pages;

use App\Filament\Resources\MediaObjectResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMediaObject extends CreateRecord
{
    protected static string $resource = MediaObjectResource::class;

    public function beforeCreate(): void
    {
        $this->record['media_path'] = $this->record['media_path']->storePublicly('media_objects', ['disk' => 'public']);

    }
}
