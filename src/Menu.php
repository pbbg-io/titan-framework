<?php

namespace PbbgIo\TitanFramework;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function items() {
        return $this->hasMany(MenuItem::class)
            ->orderBy('order', 'ASC');
    }
}
