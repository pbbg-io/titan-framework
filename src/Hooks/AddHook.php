<?php
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 2020-05-02
 * Time: 07:47
 */

namespace PbbgIo\Titan\Hooks;

class AddHook
{

    private $hook, $name;

    public function __construct(AbstractHook $hook, string $name)
    {
        $this->hook = $hook;
        $this->name = $name;
    }

    public function run()
    {
        $this->hook->listen($this->name);
    }
}
