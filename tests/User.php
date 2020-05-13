<?php

namespace PbbgIo\Titan\Tests;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use PbbgIo\Titan\Ban;
use PbbgIo\Titan\Character;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable,
        HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    public function characters() {
        return $this->hasMany(Character::class);
    }

    public function getAliveCharacters() {
        return $this->characters->filter(function($char) {
            return $char->getStat('alive');
        });
    }

    public function character() {
        return $this->hasOne(Character::class, 'id', 'last_character_played');
    }

    public function banned()
    {
        return $this->morphMany(Ban::class, 'bannable');
    }
    public function placeBan(string $reason, $time = null, bool $forever = false)
    {
        return Ban::updateOrCreate([
            'bannable_id' => $this->attributes['id'],
            'bannable_type' => get_class($this)
        ], [
            'reason' => $reason,
            'ban_until' => ($time != null ? Carbon::parse($time)->toDateString() : null),
            'forever' => $forever
        ])->exists();
    }
    public function isBanned()
    {
        return $this->banned()->exists();
    }
    public function getNameAttribute()
    {
        return $this->attributes['display_name'] ?? $this->attributes['name'];
    }
}
