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
            $this->handler($request) : (new CallbackHandler())->make($request);
    }

    /**
     * @param Request $request
     * @return mixed|void
     */
    public function handler(Request $request)
    {
        if ($request->has('message')) {
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
