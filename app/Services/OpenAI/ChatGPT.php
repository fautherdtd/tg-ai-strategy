<?php

namespace App\Services\OpenAI;

use OpenAI;

class ChatGPT
{
    public function make(string $text)
    {
        $client = OpenAI::client(getenv('OPENAI_TOKEN'));

        $result = $client->completions()->create([
            'model' => 'text-similarity-davinci-001',
            'prompt' => $text,
        ]);

        return $result['choices'][0]['text'];
    }
}
