<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class MessageBotFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'messageBot';
    }
}
