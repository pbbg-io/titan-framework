<?php

namespace PbbgIo\Titan;

use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    public function items() {
        return $this->hasMany(Item::class, 'item_category_id', 'id');
    }
}
