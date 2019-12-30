<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stats = [
            'crons',
            'areas',
            'menus',
            'stats',
            'users',
            'groups',
            'items'
        ];

        foreach($stats as $stat) {
            \Spatie\Permission\Models\Permission::create([
                'name'  =>  $stat
            ]);
        }
    }
}
