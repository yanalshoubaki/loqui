<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\MediaObject;
use Filament\Pages\Actions;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data = $data;
        $data['mediaObjects'] = Image::make(Storage::disk('public')->path($data['mediaObjects']['media_path']));
        // create new media object record
        $mediaObjectData =  [
            'media_path' => $data['mediaObjects']->basename,
            'media_type' => 'image',
            'media_name' => $data['mediaObjects']->filename,
            'media_size' => $data['mediaObjects']->filesize(),
            'media_extension' => $data['mediaObjects']->extension,
            'media_mime_type' => $data['mediaObjects']->mime
        ];
        $mediaObject = MediaObject::create($mediaObjectData);
        // update user record with media object id
        $data['profile_image_id'] = $mediaObject->id;
        $data['password'] = Hash::make($data['password']);
        return $data;
    }
}
