<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Sendler extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sendler';
    }
}
