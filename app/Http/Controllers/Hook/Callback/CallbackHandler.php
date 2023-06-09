<?php

namespace App\Http\Controllers\Hook\Callback;

use App\DTO\HookCallbackDTO;
use App\Enums\Commands;
use App\Http\Controllers\Action\Commands\CommandsController;
use App\Http\Controllers\Controller;

class CallbackHandler extends Controller
{
    /**
     * @param HookCallbackDTO $callback
     * @return false|mixed|void
     */
    public function handler(HookCallbackDTO $callback)
    {
        // Если пользователь запустил команду
        foreach ($callback->parseMarkup() as $markup) {
            if (in_array('/' . $markup, Commands::values())) {
                return (new CommandsController())->handler('/' . $markup, $callback->from_id);
            }
        }
    }
}
