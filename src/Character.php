<?php

namespace PbbgIo\Titan;

use Illuminate\Database\Eloquent\Model;
use KyleMassacre\BanUser\Entities\CanBanPlayable;

class Character extends Model
{
    use CanBanPlayable;

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

    public function items() {
        return $this->hasMany(CharacterItem::class, 'character_id', 'id');
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
