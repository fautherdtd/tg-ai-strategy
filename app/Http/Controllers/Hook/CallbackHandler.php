<?php

namespace App\Http\Controllers\Hook;

use App\Http\Controllers\Controller;
use App\Services\Sendler;
use Illuminate\Http\Request;

class CallbackHandler extends Controller
{
    public function make(Request $request)
    {
        if ($request->has('callback_query.reply_markup.inline_keyboard')) {
            foreach ($request->input('callback_query.reply_markup.inline_keyboard')[0] as $markup) {
                if ($markup['callback_data'] === 'getSkills') {
                    return $this->getSkills($request->input('callback_query.message.from.id'));
                }
            }
        }
    }


    public function getSkills(int $chatID)
    {
        $text = 'Наш бот умеет много чего';
        return Sendler::sendWithMarkup($chatID, $text, [
            [
                'text' => 'Получить стратегию продвижения',
                'callback_data' => 'get_strategy',
            ],
        ]);
    }
}
