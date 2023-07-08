<?php

namespace App\Models;

use App\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFollowing extends Model
{
    use HasFactory, HasUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'follow_id',
    ];

    /**
     * Get the follow that owns the UserFollowing
     */
    public function follow(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
