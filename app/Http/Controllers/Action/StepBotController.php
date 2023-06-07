<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\BotController;
use App\Services\Sendler;

class StepBotController extends BotController
{
    public function start(int $chatID)
    {
        $text = 'Привет! Это бот AI Strategy.';
        return Sendler::sendWithMarkup($chatID, $text, [
            [
                'text' => 'Что умеет бот',
                'callback_data' => 'get_skills',
            ]
        ]);
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
