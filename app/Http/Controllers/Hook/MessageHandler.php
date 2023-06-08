<?php

namespace App\Http\Controllers\Hook;

use App\DTO\HookMessageDTO;
use App\Enums\Commands;
use App\Http\Controllers\Action\StepBotController;
use App\Http\Controllers\Controller;

class MessageHandler extends Controller
{
    /**
     * @param HookMessageDTO $message
     * @return mixed|void
     */
    public function handler(HookMessageDTO $message)
    {
        if ($message->text === Commands::Start->name) {
            return (new StepBotController())->start($message->from_id);
        }
    }

}
