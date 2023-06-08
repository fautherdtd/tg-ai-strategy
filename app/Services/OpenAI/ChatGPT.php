<?php

namespace App\Services\OpenAI;

use OpenAI;

class ChatGPT
{
    public function test()
    {
        $client = OpenAI::client(getenv('OPENAI_TOKEN'));

        $result = $client->completions()->create([
            'model' => 'text-similarity-davinci-001',
            'prompt' => 'PHP is',
        ]);

        return $result['choices'][0]['text'];
    }
}
