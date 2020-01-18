<?php

namespace PbbgIo\Titan\Support\Facades;

use PbbgIo\Titan\Support\BanUser;

class Facade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return BanUser::class;
    }
}
