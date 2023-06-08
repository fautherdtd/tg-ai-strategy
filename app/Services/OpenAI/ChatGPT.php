<?php

namespace App\Services\OpenAI;

use OpenAI;

class ChatGPT
{
    public function test()
    {
        $client = OpenAI::client(getenv('OPENAI_TOKEN'));

        $result = $client->completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => 'PHP is',
        ]);

        return $result['choices'][0]['text'];
    }
}
