<?php

namespace App\Http\Controllers\Hook;

use App\Http\Controllers\Action\MessagesController;
use App\Http\Controllers\BotController;
use App\Models\Messages;
use Illuminate\Http\Request;

class HookMessage extends BotController
{
    public function make(Request $request)
    {
        return $request->has('message') ?
            $this->message($request) : $this->callback($request);
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
        return (new MessagesController())->send($request->input('message.from.id'), 'Работает');
    }

    public function callback(Request $request)
    {
        return true;
    }
}
