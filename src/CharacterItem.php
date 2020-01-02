<?php

namespace PbbgIo\Titan;

use Illuminate\Database\Eloquent\Model;

class CharacterItem extends Model
{

    public function item() {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }

    public function getNameAttribute() {
        if(!$this->attributes['name'])
            return $this->item->name;

        return $this->attributes['name'];
    }
}
