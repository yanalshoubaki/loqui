<?php

namespace App\Models;

use App\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    use HasUser;


    protected $fillable = [
        'user_id',
        'receiver_id',
        'notification_template_id',
        'title',
        'content',
        'url',
        'is_read'
    ];
}
