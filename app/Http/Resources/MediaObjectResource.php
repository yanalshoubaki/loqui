<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaObjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'media_path' => env("APP_URL") . "/storage/$this->media_path",
            'media_type' => $this->media_type,
            'media_name' => $this->media_name,
            'media_size' => $this->media_size,
            'media_extension' => $this->media_extension,
            'media_mime_type' => $this->media_mime_type,
            'media_dimensions' => $this->media_dimensions
        ];
    }
}
