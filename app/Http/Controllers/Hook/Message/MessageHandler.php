<?php

namespace App\Http\Controllers\Hook\Message;

use App\DTO\HookMessageDTO;
use App\Enums\Commands;
use App\Http\Controllers\Action\Commands\CommandsController;
use App\Http\Controllers\Action\GPT\ActionGPT;
use App\Http\Controllers\Action\SendlerChatGPT;
use App\Services\Sendler;
use Illuminate\Support\Facades\Redis;
use App\Services\Telegram\BuilderMessage;

class MessageHandler
{
    /**
     * @param HookMessageDTO $message
     * @return mixed|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handler(HookMessageDTO $message)
    {
        // Если пользователь запустил команду
        if (in_array('/' . $message->text, Commands::values())) {
            return (new CommandsController())->handler(
                preg_replace('/[^a-zA-Z]/', '', $message->text),
                $message->from_id);
        }

        // Если мы находимся в режиме диалога
        if (Redis::exists('create_idea_' . $message->from_id)) {
            return (new ActionGPT())->finishedCreateIdea($message->from_id, $message->text);
        }

        // Отправляем дефолтное сообщение
        return $this->defaultAnswer($message->from_id);
    }

    /**
     * @param int $fromID
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function defaultAnswer(int $fromID): mixed
    {
        $builder = new BuilderMessage($fromID);
        $query = $builder->text(file_get_contents(resource_path('views/templates/default.html')))
            ->buildText([
                $builder->textKeyboard('❔ Как начать работу')
                    ->callbackKeyboard('how_to_start')
                    ->inlineFull()
            ]);
        return Sendler::send($query);
    }

}
