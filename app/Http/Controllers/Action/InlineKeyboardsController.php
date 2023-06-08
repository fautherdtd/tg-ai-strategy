<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Services\Sendler;

class InlineKeyboardsController extends Controller
{

    /**
     * @param int $chatID
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
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
