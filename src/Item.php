<?php

namespace PbbgIo\Titan;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'description',
        'consumable_uses',
        'cost',
        'item_category_id',
        'consumable',
        'stackable',
        'buyable',
        'equippable'
    ];

    public $casts = [
        'consumable' => 'boolean',
        'equippable' => 'boolean',
        'buyable' => 'boolean',
        'stackable' => 'boolean',
    ];

    public function category()
    {
        return $this->hasOne(ItemCategory::class, 'id', 'item_category_id');
    }

    public function stats()
    {
        return $this->hasMany(ItemStat::class, 'item_id', 'id');
    }

    public function getCostAttribute()
    {
        if (!$this->attributes['cost']) {
            return 0;
        }

        return $this->attributes['cost'];
    }
}
