<?php

namespace App\Models;

use App\Traits\HasMediaObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppInfo extends Model {
    use HasFactory;
    use HasMediaObject;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'app_name',
        'app_description',
        'media_object_id',
        'app_url',
        'app_email',
    ];
}
