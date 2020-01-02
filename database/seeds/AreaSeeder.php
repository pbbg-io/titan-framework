<?php

use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = [
            'London',
            'Isengard',
            'Aleppo',
        ];

        foreach($areas as $area)
        {
            $a = new \PbbgIo\Titan\Area();
            $a->name = $area;
            $a->save();
        }
    }
}
