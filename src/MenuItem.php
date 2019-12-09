<?php

namespace PbbgIo\TitanFramework;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    public function child()
    {
        return $this->hasMany(MenuItem::class, 'parent_id', 'id')->orderBy('order');
    }

    public function deleteRecursively()
    {
        if ($this->child) {
            foreach ($this->child as $child) {
                $child->deleteSingle($child);
            }
        }
    }

    private function deleteSingle($child)
    {
        if(!$child)
            return;

        if ($child->child->count() > 0) {
            $this->deleteSingle($child->child);
        }

        $child->delete();
    }

    public function getUrlOrRouteAttribute() {
        if(\Route::has($this->route))
        {
            return route($this->route);
        }

        return $this->route;
    }
}
