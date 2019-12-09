<?php

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $menu = new \PbbgIo\TitanFramework\Menu();
        $menu->name = 'General';
        $menu->enabled = true;
        $menu->save();

        $items = [
            [
                'name'  =>  'test',
                'route' =>  'home',
                'children'  =>  [
                    [
                        'name'  =>  'test nested',
                        'route' =>  'home'
                    ],
                    [
                        'name'  =>  'test nested',
                        'route' =>  'home'
                    ],
                    [
                        'name'  =>  'test nested',
                        'route' =>  'home'
                    ],
                ]
            ],

            [
                'name'  =>  'test3',
                'route' =>  'home',
            ]
        ];

        foreach($items as $item)
        {
            $this->addItem($item, $menu);
        }


    }

    private function addItem(array $item, \PbbgIo\TitanFramework\Menu $menu, $parent = null) {
        $menuItem = new \PbbgIo\TitanFramework\MenuItem();
        $menuItem->name = $item['name'];
        $menuItem->route = $item['route'];
        $menuItem->menu_id = $menu->id;

        if($parent)
            $menuItem->parent_id = $parent->id;

        $menuItem->save();

        if(isset($item['children']))
        {
            foreach($item['children'] as $child)
            {
                $this->addItem($child, $menu, $menuItem);
            }
        }
    }
}
