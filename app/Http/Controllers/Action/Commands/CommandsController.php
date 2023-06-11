<?php

namespace App\Http\Controllers\Action\Commands;

use App\Enums\Commands;
use App\Http\Controllers\Builders;
use App\Services\Sendler;
use Illuminate\Support\Facades\Redis;

class CommandsController
{
    use Builders;
    /**
     * @var array|string[]
     */
    protected array $functions = [
        'start' => 'start',
        'about_me' => 'aboutMe',
        'menu' => 'menu',
        'start_gpt' => 'startGPT',
        'stop_gpt' => 'stopGPT'
    ];
    /**
     * @param string $command
     * @param string $chatID
     * @return false|mixed|void
     */
    public function handler(string $command, string $chatID)
    {
        $function = $this->functions[preg_replace('/[^a-zA-Z_]/', '', $command)];
        return call_user_func('self::' . $function, $chatID);
    }

    /**
     * @param $chatID
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected static function start($chatID): mixed
    {
        $text = file_get_contents(resource_path('views/templates/start.html'));
        return Sendler::sendImageAndText($chatID, $text, 'https://tg-ai-strategy.shelit.agency/images/hello-img.jpg');
    }

    /**
     * @param int $chatID
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected static function aboutMe(int $chatID): mixed
    {
        $text = file_get_contents(resource_path('views/templates/about_me.html'));
        return Sendler::sendImageAndText($chatID, $text, 'https://tg-ai-strategy.shelit.agency/images/about-me.jpg');
    }

    /**
     * @param int $chatID
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected static function startGPT(int $chatID): mixed
    {
        Redis::set('start_gpt_' . $chatID, true);
        $text = file_get_contents(resource_path('views/templates/start_gpt.html'));
        return Sendler::send($chatID, $text);
    }

    /**
     * @param int $chatID
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected static function stopGPT(int $chatID): mixed
    {
        Redis::del('start_gpt_' . $chatID, true);
        $text = file_get_contents(resource_path('views/templates/stop_gpt.html'));
        return Sendler::send($chatID, $text);
    }

    /**
     * @param int $chatID
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected static function menu(int $chatID)
    {
        $text = file_get_contents(resource_path('views/templates/menu.html'));
        return Sendler::sendWithMarkup($chatID, $text, [
            [
                self::builderInlineKeyboard()
                    ->text('🤖 Подробнее про меня')
                    ->callback('about_me')
                    ->inlineFull()
            ],
            [
                self::builderInlineKeyboard()
                    ->text('💬 Включить режим диалога')
                    ->callback('start_gpt')
                    ->inlineFull()
            ]
        ]);
    }
}
