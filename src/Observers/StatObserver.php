<?php

namespace PbbgIo\Titan\Observers;

use PbbgIo\Titan\Character;
use PbbgIo\Titan\CharacterStat;
use PbbgIo\Titan\Stat;

class StatObserver
{
    public function created(Stat $stat) {
        // When creating a stat we need to seed it to all the existing characters
        Character::chunk(50, function($characters) use($stat) {
            foreach($characters as $character)
            {
                $s = new CharacterStat();
                $s->character_id = $character->id;
                $s->stat_id = $stat->id;
                $s->value = $stat->default;
                $s->save();
            }
        });
    }

    public function deleted(Stat $stat) {
        // Flush existing character stats
        CharacterStat::where('stat_id', $stat)->delete();
    }
}
