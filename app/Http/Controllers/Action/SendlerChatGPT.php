<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Services\OpenAI\ChatGPT;

class SendlerChatGPT extends Controller
{
    public function send(string $text)
    {
        return (new ChatGPT())->make($text);
    }

    public function saveMessage(array $array)
    {

    }
}
