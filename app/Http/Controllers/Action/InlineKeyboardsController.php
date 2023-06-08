<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Services\Sendler;
use Illuminate\Support\Facades\Redis;

class InlineKeyboardsController extends Controller
{

    /**
     * @param int $chatID
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function aboutMe(int $chatID): mixed
    {
        $text = file_get_contents(resource_path('views/templates/about_me.html'));
        return Sendler::sendWithMarkup($chatID, $text, [
            [
                'text' => 'Список команд',
                'callback_data' => 'get_commands',
            ],
        ]);
    }

    /**
     * @param int $chatID
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function startGPT(int $chatID): mixed
    {
        Redis::set('start_gpt_' . $chatID, true);
        $text = file_get_contents(resource_path('views/templates/start_gpt.html'));
        return Sendler::send($chatID, $text);
    }
}
