<?php

namespace App\Http\Controllers\Hook;

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
            $this->handler($request) : $this->callback($request);
    }

    /**
     * @param Request $request
     * @return mixed|void
     */
    public function handler(Request $request)
    {
        if ($request->has('message')) {
            Sendler::send($request->input('message.from.id'), '123');
            if ($request->input('message.text') === '/start') {
                $this->savedMessage($request);
                return (new StepBotController())->start(
                    $request->input('message.from.id')
                );
            }
            return $this->message($request);
        }
    }


    public function message(Request $request)
    {
        return Sendler::send($request->input('message.from.id'), 'Работает');
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
        return Sendler::send(
            $request->input('callback_query.message.from.id'),
            'Кнопка'
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
