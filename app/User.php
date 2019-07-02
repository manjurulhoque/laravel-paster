<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'role', 'status', 'avatar', 'about', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        if ($this->role == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getAvatarAttribute()
    {
        return $this->attributes['avatar'] ? asset('uploads/' . $this->attributes['avatar']) : asset('images/guest.png');
    }

    public function pastes()
    {
        return $this->hasMany(Paste::class);
    }
}
