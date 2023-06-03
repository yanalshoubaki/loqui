<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateMediaObjectRequest;
use App\Models\MediaObject;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MediaObjectController extends ApiHandler
{
    /**
     * Create a new media object
     *
     * @param CreateMediaObjectRequest $request
     * @return JsonResponse
     */
    public function createNewMediaObject(CreateMediaObjectRequest $request): JsonResponse
    {
        try {
            $image = date('Y') . "/" . date('m') . '/' . random_int(500, 999) * time() . '.' . $request->media->extension();
            /** @var \Illuminate\Contracts\Filesystem\Filesystem  $publicStorage */
            Storage::putFileAs('public', $request->media, $image, 'public');
            $mediaImage = Image::make(storage_path('app/public/' . $image));
            $mediaObject = MediaObject::create([
                'media_path' => $image,
                'media_type' => 'image',
                'media_name' => $mediaImage->filename,
                'media_size' => $mediaImage->filesize(),
                'media_extension' => $mediaImage->extension,
                'media_mime_type' => $mediaImage->mime
            ]);
            return $this->getResponse($mediaObject, "Upload media success", "success");
        } catch (\Throwable $th) {
            return $this->getResponse(null, $th->getMessage(), "error");
        }
    }

    /**
     * Delete a media object
     *
     * @param MediaObject $mediaObject
     * @return JsonResponse
     */
    public function deleteMediaObject(MediaObject $mediaObject): JsonResponse
    {
        try {
            /** @var \Illuminate\Contracts\Filesystem\Filesystem  $publicStorage */
            $publicStorage = Storage::disk('public');
            $publicStorage->delete($mediaObject->media_path);
            $mediaObject->delete();
            return $this->getResponse(null, "Delete media success", "success");
        } catch (\Throwable $th) {
            return $this->getResponse(null, $th->getMessage(), "error");
        }
    }
}
