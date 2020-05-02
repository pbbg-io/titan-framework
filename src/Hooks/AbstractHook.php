<?php
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 2020-05-02
 * Time: 08:39
 */

namespace PbbgIo\Titan\Hooks;

abstract class AbstractHook
{
    abstract public function listen(string $name);
}
