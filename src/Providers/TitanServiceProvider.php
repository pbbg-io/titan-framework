<?php
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 2020-05-02
 * Time: 06:17
 */

namespace PbbgIo\Titan\Providers;

use Illuminate\Support\ServiceProvider;
use PbbgIo\Titan\Hooks\AddHook;

class TitanServiceProvider extends ServiceProvider
{

    protected $hooks = [];

    private function registerHooks()
    {
        foreach ($this->hooks as $name => $listeners)
        {
            foreach (array_unique($listeners) as $listener) {
                $hook = new AddHook(new $listener, $name);
                $hook->run();
            }
        }
    }

    public function boot()
    {

    }

    public function register()
    {
        $this->registerHooks();
    }
}
