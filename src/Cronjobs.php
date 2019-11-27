<?php

namespace PbbgIo\TitanFramework;

use Illuminate\Database\Eloquent\Model;

class Cronjobs extends Model
{
    protected $casts = [
        'enabled'   =>  'bool'
    ];

    protected $fillable = [
        'command',
        'cron',
        'enabled',
    ];
}
