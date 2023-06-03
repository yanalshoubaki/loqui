<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Intervention\Image\Facades\Image;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MediaObject>
 */
class MediaObjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $placeHolderImage = Image::make(resource_path('images/placeholder.png'));

        return [
            'media_path' => $placeHolderImage->basePath(),
            'media_type' => 'image',
            'media_name' => $placeHolderImage->filename,
            'media_size' => $placeHolderImage->filesize(),
            'media_extension' => $placeHolderImage->extension,
            'media_mime_type' => $placeHolderImage->mime,
        ];
    }
}
