<?php

namespace PbbgIo\TitanFramework;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{

    protected $casts = [
        'last_move' =>  'datetime'
    ];

    protected $appends = [
        'current_area'
    ];

    protected $fillable = [
        'display_name',
        'area_id'
    ];

    /**
     * Characters stats
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stats() {
        return $this->hasMany(CharacterStat::class);
    }

    /**
     * Characters current area
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function area() {
        return $this->hasOne(Area::class, 'id', 'area_id');
    }

    /**
     * Get custom attribute `current_area` which returns the name of the current area
     *
     * @return mixed
     */
    public function getCurrentAreaAttribute() {
        return $this->area->name;
    }

    public function seedStats() {
        $stats = Stat::all();

        foreach($stats as $stat) {
            $cs = new CharacterStat();
            $cs->character_id = $this->id;
            $cs->stat_id = $stat->id;
            $cs->value = $stat->default;
            $cs->save();
        }
    }

}
