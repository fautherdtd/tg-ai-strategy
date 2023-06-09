<?php

namespace App\Http\Controllers\Hook;

use App\DTO\HookMessageDTO;
use App\Enums\Commands;
use App\Enums\InlineKeyboards;
use App\Http\Controllers\Action\InlineKeyboardsController;
use App\Http\Controllers\Action\SendlerChatGPT;
use App\Http\Controllers\Action\StepBotController;
use App\Http\Controllers\Controller;
use App\Services\Sendler;
use Illuminate\Support\Facades\Redis;

class MessageHandler extends Controller
{
    /**
     * @param HookMessageDTO $message
     * @return mixed|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handler(HookMessageDTO $message)
    {
        // Проверяем на наличие команд
        $this->handlerCommands($message);

        // Проверяем был ли запущен диалог
        if (Redis::exists('start_gpt_' . $message->from_id)) {
            return Sendler::send(
                $message->from_id,
                (new SendlerChatGPT())->send($message->text),
                'text'
            );
        }
        // Send to Default answer
        return $this->defaultAnswer($message->from_id);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function handlerCommands(HookMessageDTO $message)
    {
        if ($message->text === Commands::Start->value) {
            return (new StepBotController())->start($message->from_id);
        }
        if ($message->text === Commands::StartGPT->value) {
            return (new InlineKeyboardsController())->startGPT($message->from_id);
        }
        if ($message->text === Commands::StopGPT->value) {
            return (new InlineKeyboardsController())->stopGPT($message->from_id);
        }
        if ($message->text === Commands::AboutMe->value) {
            return (new InlineKeyboardsController())->aboutMe($message->from_id);
        }
    }

    /**
     * @param int $fromID
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function defaultAnswer(int $fromID): mixed
    {
        $text = file_get_contents(resource_path('views/templates/default.html'));
        return Sendler::sendWithMarkup($fromID, $text, [
            [
                'text' => 'Включить режим диалога',
                'callback_data' => 'start_gpt',
            ]
        ]);
    }

}
