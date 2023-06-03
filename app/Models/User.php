<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasMedia;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Althinect\FilamentSpatieRolesPermissions\Concerns\HasSuperAdmin;

class User extends Authenticatable  implements FilamentUser
{
    use HasFactory;
    use Notifiable;
    use HasMedia;
    use HasApiTokens;
    use HasRoles;
    use HasSuperAdmin;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'profile_image_id',
        'email',
        'status',
        'password',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];


    public static $filamentUserColumn = 'is_filament_user'; // The name of a boolean column in your database.


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function meta()
    {
        return $this->hasMany(UserMeta::class, 'user_id');
    }

    public function authApp()
    {
        return $this->hasMany(UserAuthApp::class, 'user_id');
    }

    public function following()
    {
        return $this->hasMany(UserFollow::class, 'user_id');
    }

    public function follower()
    {
        return $this->hasMany(UserFollow::class, 'follow_id');
    }

    public function social()
    {
        return $this->hasMany(UserSocial::class, 'user_id');
    }
    public function messages()
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    public function mediaObject()
    {
        return $this->belongsTo(MediaObject::class, 'profile_image_id', 'id');
    }
    public function canAccessFilament(): bool
    {
        return str_ends_with($this->email, '@yanalshoubaki.com');
    }
}
