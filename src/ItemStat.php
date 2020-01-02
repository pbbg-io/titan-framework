<?php

namespace PbbgIo\Titan;

use Illuminate\Database\Eloquent\Model;

class ItemStat extends Model
{
    protected $fillable = [
        'key',
        'value',
        'item_id'
    ];
}
