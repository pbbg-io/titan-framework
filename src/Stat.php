<?php

namespace PbbgIo\Titan;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    protected $table = 'defined_stats';

    public const TYPE_INTEGER = 'integer';
    public const TYPE_BOOLEAN = 'boolean';
    public const TYPE_STRING = 'string';
    public const TYPE_TEXT = 'text';
    public const TYPE_FLOAT = 'float';

    protected $fillable = [
        'stat',
        'description',
        'type',
        'default'
    ];

    public const AVAILABLE_TYPES = [
        self::TYPE_BOOLEAN,
        self::TYPE_INTEGER,
        self::TYPE_FLOAT,
        self::TYPE_STRING,
        self::TYPE_TEXT
    ];

    public function getDefaultAttribute()
    {
        $value = $this->attributes['default'];
        switch ($this->type) {
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
