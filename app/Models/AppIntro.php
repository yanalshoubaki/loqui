<?php

namespace App\Models;

use App\Traits\HasMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppIntro extends Model
{
    use HasFactory;
    use HasMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'intro_title',
        'intro_description',
        'intro_image_id',
    ];

    public function mediaObject()
    {
        return $this->belongsTo(MediaObject::class, 'intro_image_id', 'id');
    }
}
