<?php

namespace App\Http\Controllers\Hook;

use App\Http\Controllers\Action\StepBotController;
use App\Http\Controllers\BotController;
use App\Http\Facades\MessagesBot;
use App\Models\Messages;
use Illuminate\Http\Request;

class HookMessage extends BotController
{
    public function make(Request $request)
    {
        return $request->has('message') ?
            $this->message($request) : $this->callback($request);
    }

    protected function handler(Request $request)
    {
        if ($request->has('message')) {
            return $request->input('message.text') === '/start' ?
                (new StepBotController())->start(
                    $request->input('message.from.id')
                ) : $this->message($request);
        }
    }

    public function message(Request $request)
    {
        $model = Messages::create([
            'message_id' => $request->input('message.message_id'),
            'from' => $request->input('message.from'),
            'chat' => $request->input('message.chat'),
            'text' => $request->input('message.text'),
            'type' => 'message',
            'user_id' => $request->input('message.from.id')
        ]);
        return (new MessagesBot())->send($request->input('message.from.id'), 'Работает');
    }

    public function callback(Request $request)
    {

        $model = Messages::create([
            'message_id' => $request->input('callback_query.message.message_id'),
            'from' => $request->input('callback_query.message.from'),
            'chat' => $request->input('callback_query.message.chat'),
            'text' => $request->input('callback_query.message.text'),
            'type' => 'callback',
            'user_id' => $request->input('callback_query.message.from.id')
        ]);
        return (new MessagesBot())->send(
            $request->input('callback_query.message.from.id'),
            'Кнопка'
        );
    }
}
