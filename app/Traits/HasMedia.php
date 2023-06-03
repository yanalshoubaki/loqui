<?php

namespace App\Traits;

use App\Models\MediaObject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasMedia
{
    /**
     * Get the media object that owns the model.
     *
     * @return BelongsTo
     */
    public function media(): BelongsTo
    {
        return $this->belongsTo(MediaObject::class);
    }
}
