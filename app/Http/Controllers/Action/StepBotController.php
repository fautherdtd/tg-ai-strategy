<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\BotController;
use App\Http\Facades\MessagesBot;

class StepBotController extends BotController
{
    public function start(int $chatID)
    {
        $text = 'Привет! Это бот AI Strategy.';
        MessagesBot::sendWithMarkup($chatID, $text, [
            [
                'text' => 'Что умеет бот',
                'callback_data' => 'get_skills',
            ]
        ]);
    }

    public function getSkills(int $chatID)
    {
        $text = 'Наш бот умеет много чего';
        MessagesBot::sendWithMarkup($chatID, $text, [
            [
                'text' => 'Получить стратегию продвижения',
                'callback_data' => 'get_strategy',
            ],
        ]);
    }
}
