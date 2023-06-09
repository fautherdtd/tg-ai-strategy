<?php

namespace App\Http\Controllers\Hook;

use App\DTO\HookCallbackDTO;
use App\DTO\HookMessageDTO;
use App\Http\Controllers\Hook\Callback\CallbackHandler;
use App\Http\Controllers\Hook\Message\MessageHandler;
use Illuminate\Http\Request;

class HandlerHook
{
    /**
     * @param Request $request
     * @return mixed|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function make(Request $request)
    {
        if ($request->has('message')) {
            $dto = new HookMessageDTO($request);
            $message = new MessageHandler();
            return $message->handler($dto);
        }
        if ($request->has('callback_query')) {
            $dto = new HookCallbackDTO($request);
            $callback = new CallbackHandler();
            return $callback->handler($dto);
        }
    }
}
