<?php

namespace App\Http\Controllers\Hook;

use App\DTO\HookCallbackDTO;
use App\DTO\HookMessageDTO;
use App\Http\Controllers\Action\StepBotController;
use App\Http\Controllers\BotController;
use App\Models\Messages;
use App\Services\Sendler;
use Illuminate\Http\Request;

class HookMessage extends BotController
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function make(Request $request)
    {
        return $request->has('message') ?
            (new MessageHandler())->handler(
                new HookMessageDTO($request)
            ) :
            (new CallbackHandler())->handler(
                new HookCallbackDTO($request)
            );
    }

    /**
     * @param Request $request
     * @return void
     */
    protected function savedMessage(Request $request)
    {
        Messages::create([
            'message_id' => $request->input('message.message_id'),
            'from' => $request->input('message.from'),
            'chat' => $request->input('message.chat'),
            'text' => $request->input('message.text'),
            'type' => 'message',
            'user_id' => $request->input('message.from.id')
        ]);
    }
}
