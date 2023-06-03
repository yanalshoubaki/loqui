<?php

namespace App\Filament\Resources\AppIntroResource\Pages;

use App\Filament\Resources\AppIntroResource;
use App\Models\MediaObject;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CreateAppIntro extends CreateRecord
{
    protected static string $resource = AppIntroResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['mediaObjects'] = Image::make(Storage::disk('public')->path($data['mediaObjects']['media_path']));
        // create new media object record
        $mediaObjectData = [
            'media_path' => $data['mediaObjects']->basename,
            'media_type' => 'image',
            'media_name' => $data['mediaObjects']->filename,
            'media_size' => $data['mediaObjects']->filesize(),
            'media_extension' => $data['mediaObjects']->extension,
            'media_mime_type' => $data['mediaObjects']->mime,
        ];
        $mediaObject = MediaObject::create($mediaObjectData);
        // update user record with media object id
        $data['intro_image_id'] = $mediaObject->id;

        return $data;
    }
}
