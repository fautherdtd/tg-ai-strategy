<?php

namespace App\Services\OpenAI;

use OpenAI;

class ChatGPT
{
    public function make(string $text)
    {
        $client = OpenAI::client(getenv('OPENAI_TOKEN'));

        $result = $client->completions()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $text],
            ],
        ]);

        return $result['choices'][0]['message']['content'];
    }
}
