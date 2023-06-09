<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

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
