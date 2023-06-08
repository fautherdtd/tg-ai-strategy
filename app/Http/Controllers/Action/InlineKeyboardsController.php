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
    public function aboutMe(int $chatID)
    {
        $text = file_get_contents(resource_path('views/templates/about_me.html'));
        return Sendler::sendWithMarkup($chatID, $text, [
            [
                'text' => 'Список команд',
                'callback_data' => 'get_commands',
            ],
        ]);
    }
}
