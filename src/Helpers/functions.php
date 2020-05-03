<?php

use Esemve\Hook\Facades\Hook;

if(!function_exists('character'))
{
    function character() {
        return \Auth::user()->character;
    }
}

if(!function_exists('run_hook'))
{
    function run_hook(string $name, array $params, callable $callback)
    {
        return Hook::get($name, $params, $callback);
    }
}

if(!function_exists('hook_listen'))
{
    function hook_listen(string $name, callable $callback, $priority = 10)
    {
        Hook::listen($name, $callback, $priority);
    }
}
