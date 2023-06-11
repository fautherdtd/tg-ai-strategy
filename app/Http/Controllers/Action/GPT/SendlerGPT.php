<?php

namespace App\Http\Controllers\Action\GPT;

use App\Services\OpenAI\ChatGPT;
use App\Services\Sendler;
use Illuminate\Support\Facades\Redis;

class SendlerGPT
{
    public ChatGPT $gpt;

    public function start(string $text, ...$options)
    {
        // TODO: написать качественный текст вступления для работы с GPT
        $caption = 'Ты лучший маркетолог в мире и нанят в мою команду. Сейчас твоя задача выслушать мою идею
        и когда я дам тебе задачу, ты должен выполнить ее максимально качественно и правильно. Мой бизнес - ' . $text
        . 'После того, как ты выслушал про мой бизнес, запомни и жди дальнейшие мои задачи.';
        $result = $this->gpt->make($caption);

        // TODO: вынести за пределы
        Redis::del('start_gpt_' . $options['chat_id'], true);
        return Sendler::send($options['chat_id'], $result);
    }
}
