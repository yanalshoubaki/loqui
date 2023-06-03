<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\ApiHandler;
use App\Models\MediaObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MediaObjectController extends ApiHandler
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
            return $mediaObject;
        } catch (\Throwable $th) {
            return $this->getResponse(null, $th->getMessage(), "error");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MediaObject $mediaObject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MediaObject $mediaObject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MediaObject $mediaObject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MediaObject $mediaObject)
    {
        //
    }
}
