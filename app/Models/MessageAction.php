<?php

namespace App\Models;

use App\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageAction extends Model
{
    use HasFactory;
    use HasUser;

    protected $fillable = [
        'user_id',
        'message_id',
        'action',
    ];
}
