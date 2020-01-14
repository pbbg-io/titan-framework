<?php

namespace PbbgIo\Titan;

use Illuminate\Database\Eloquent\Model;

class CharacterStat extends Model
{
    protected $with = [
        'type'
    ];

    /**
     * Get the defined type of the stat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type()
    {
        return $this->hasOne(Stat::class, 'id', 'stat_id');
    }

    /**
     * Case the value to the correct type as per the defined stat
     *
     * @return bool|float|int|mixed|string
     */
    public function getValueAttribute()
    {
        $value = $this->attributes['value'];
        switch ($this->type->type) {
            case 'boolean':
                return (bool)$value;
            case 'string':
            case 'text':
                return (string)$value;
            case 'integer':
                return (int)$value;
            case 'float':
                return (float)$value;
            default:
                return $value;
        }
    }
}
