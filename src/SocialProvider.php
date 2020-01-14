<?php

namespace PbbgIo\Titan;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SocialProvider extends Model
{
    protected $fillable = ['user_id', 'provider', 'providerId', 'avatar'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
