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
        if (in_array('/' . $callback->data, Commands::values())) {
            return (new CommandsController())->handler($callback->data, $callback->from_id);
        }
    }
}
