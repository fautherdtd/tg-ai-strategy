<?php

namespace App\Http\Controllers\Hook;

use App\DTO\HookCallbackDTO;
use App\Enums\InlineKeyboards;
use App\Http\Controllers\Action\InlineKeyboardsController;
use App\Http\Controllers\Controller;
use App\Services\Sendler;
use Illuminate\Support\Facades\Redis;

class CallbackHandler extends Controller
{
    public function handler(HookCallbackDTO $callback)
    {
        if (in_array(InlineKeyboards::AboutMe->value, $callback->parseMarkup())) {
            return (new InlineKeyboardsController())->aboutMe($callback->from_id);
        }
        if (in_array(InlineKeyboards::StartGPT->value, $callback->parseMarkup())) {
            return (new InlineKeyboardsController())->startGPT($callback->from_id);
        }
        if (in_array(InlineKeyboards::StopGPT->value, $callback->parseMarkup())) {
            return (new InlineKeyboardsController())->stopGPT($callback->from_id);
        }
    }
}
