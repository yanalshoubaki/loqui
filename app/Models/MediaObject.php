<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaObject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'media_path',
        'media_type',
        'media_name',
        'media_size',
        'media_extension',
        'media_mime_type',
        'media_dimensions',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'media_object_id', 'id');
    }

    public function appIntro()
    {
        return $this->hasMany(AppIntro::class, 'intro_image_id', 'id');
    }
}
