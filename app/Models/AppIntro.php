<?php

namespace App\Models;

use App\Traits\HasMediaObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppIntro extends Model {
    use HasFactory;
    use HasMediaObject;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'intro_title',
        'intro_description',
        'media_object_id',
    ];

    public function mediaObject() {
        return $this->belongsTo(MediaObject::class, 'intro_image_id', 'id');
    }
}
