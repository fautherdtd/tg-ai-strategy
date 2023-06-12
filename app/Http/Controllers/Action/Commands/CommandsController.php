<?php

namespace App\Http\Controllers\Action\Commands;

use App\Enums\Commands;
use App\Http\Controllers\Builders;
use App\Models\ContextGPT;
use App\Services\Sendler;
use App\Services\Telegram\BuilderMessage;
use Illuminate\Support\Facades\Redis;

class CommandsController
{
    use Builders;
    /**
     * @var array|string[]
     */
    protected array $functions = [
        'start' => 'start',
        'how_to_start' => 'howToStart',
        'start_create_idea' => 'startCreateIdea',
        'about_me' => 'aboutMe',
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
        $builder = new BuilderMessage($chatID);
        $query = $builder->text(file_get_contents(resource_path('views/templates/start.html')))
            ->image('https://tg-ai-strategy.shelit.agency/images/hello-img.jpg')
            ->buildImage([
                $builder->getButton('how_to_start'),
                $builder->getButton('how_to_start')
            ]);
        return Sendler::sendImage($query);
    }

    /**
     * @param int $chatID
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected static function howToStart(int $chatID): mixed
    {
        $builder = new BuilderMessage($chatID);
        $query = $builder->text(file_get_contents(resource_path('views/templates/how_to_start.html')))
            ->buildText([
                $builder->textKeyboard('💬 Рассказать свою идею / бизнес')
                    ->callbackKeyboard('start_create_idea')
                    ->inlineFull()
            ]);
        return Sendler::send($query);
    }

    /**
     * @param int $chatID
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected static function startCreateIdea(int $chatID): mixed
    {
        Redis::set('create_idea_' . $chatID, true);
        $builder = new BuilderMessage($chatID);
        $query = $builder->text(file_get_contents(resource_path('views/templates/start_create_idea.html')))
            ->buildText();
        return Sendler::send($query);
    }

    /**
     * @param int $chatID
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected static function aboutMe(int $chatID): mixed
    {
        $builder = new BuilderMessage($chatID);
        $query = $builder->text(file_get_contents(resource_path('views/templates/about_me.html')))
            ->image('https://tg-ai-strategy.shelit.agency/images/about-me.jpg')
            ->buildImage();
        return Sendler::sendImage($query);
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
}
