<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageReplay extends Model
{
    use HasFactory;
    protected $fillable = [
        'message_id',
        'user_id',
        'replay',
        'image_id'
    ];

    public function message() {
        return $this->belongsTo(Message::class, 'message_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mediaObject() {
        return $this->belongsTo(MediaObject::class, 'image_id');
    }

}
