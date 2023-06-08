<?php

namespace App\Http\Controllers\Hook;

use App\DTO\HookCallbackDTO;
use App\Enums\InlineKeyboards;
use App\Http\Controllers\Action\InlineKeyboardsController;
use App\Http\Controllers\Controller;

class CallbackHandler extends Controller
{
    public function handler(HookCallbackDTO $callback)
    {
        if (in_array(InlineKeyboards::AboutMe->value, $callback->parseMarkup())) {
            return (new InlineKeyboardsController())->aboutMe($callback->from_id);
        }
    }


}
