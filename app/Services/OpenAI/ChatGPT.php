<?php

namespace App\Services\OpenAI;

use OpenAI;

class ChatGPT
{
    public function make(string $text)
    {
        $client = OpenAI::client(getenv('OPENAI_TOKEN'));

        $response = $client->completions()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $text],
            ],
        ]);

        foreach ($response->choices as $result) {
            return $result->message->content;
        }
    }
}
