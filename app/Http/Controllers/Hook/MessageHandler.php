<?php

namespace App\Http\Controllers\Hook;

use App\DTO\HookMessageDTO;
use App\Enums\Commands;
use App\Http\Controllers\Action\StepBotController;
use App\Http\Controllers\Controller;
use App\Services\Sendler;

class MessageHandler extends Controller
{
    /**
     * @param HookMessageDTO $message
     * @return mixed|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handler(HookMessageDTO $message)
    {
        if ($message->text === Commands::Start->value) {
            return (new StepBotController())->start($message->from_id);
        }
        return $this->defaultAnswer($message->from_id);
    }

    public function defaultAnswer(int $fromID)
    {
        $text = file_get_contents(resource_path('views/templates/start.html'));
        return Sendler::sendWithMarkup(
            $fromID,
            $text,
            [
                [
                    'text' => 'Включить режим диалога',
                    'callback_data' => 'start_gpt',
                ]
            ],
        );
    }

}
