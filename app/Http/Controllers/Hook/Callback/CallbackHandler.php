<?php

namespace App\Http\Controllers\Hook\Callback;

use App\DTO\HookCallbackDTO;
use App\Enums\Commands;
use App\Enums\GPTAction;
use App\Http\Controllers\Action\Commands\CommandsController;
use App\Http\Controllers\Action\GPT\TaskGPT;
use App\Http\Controllers\Controller;
use App\Models\ContextGPT;

class CallbackHandler extends Controller
{
    /**
     * @param HookCallbackDTO $callback
     * @return false|mixed|void
     */
    public function handler(HookCallbackDTO $callback)
    {
        // Action command default
        if (in_array($callback->data, Commands::values())) {
            return (new CommandsController())->handler($callback->data, $callback->from_id);
        }

        // Action command GPT
        if (in_array($callback->data, GPTAction::values())) {
            if (! ContextGPT::where('chat_id', $callback->from_id)->exists()) {
                return (new CommandsController())->handler('howToStart', $callback->from_id);
            }
            return (new TaskGPT($callback->from_id))->getTask($callback->data);
        }
    }
}
