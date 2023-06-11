<?php

namespace App\Http\Controllers\Action\GPT;

use App\Models\ContextGPT;
use App\Services\OpenAI\ChatGPT;
use App\Services\Sendler;
use Illuminate\Support\Facades\Redis;

class ActionGPT
{
    public ChatGPT $gpt;

    public function createIdea(string $idea, ...$options)
    {
        $model = new ContextGPT();
        Redis::del('start_gpt_' . $options['chat_id'], true);
        if ($model->where('chat_id', $options['chat_id'])->exists()) {
            $text = file_get_contents(resource_path('views/templates/create_idea.html'));
            return Sendler::sendWithMarkup($options['chat_id'], $text, [
                [
                    [
                        'text' => '⚠️ Удалить мою идею и предложить новую.',
                        'callback_data' => 'delete_idea'
                    ]
                ],
                [
                    [
                        'text' => '🎯 Посмотреть мой функционал',
                        'callback_data' => 'commands_idea'
                    ]
                ],
            ]);
        } else {
            $text = file_get_contents(resource_path('views/templates/exists_idea.html'));
            $model->chat_id = $options['chat_id'];
            $model->context = $idea;
            $model->save();
        }
        return Sendler::sendWithMarkup($options['chat_id'], $text, [
            [
                [
                    'text' => '🚀 Проанализировать рынок',
                    'callback_data' => 'analysis_market'
                ]
            ],
            [
                [
                    'text' => '🎯 Проработать стратегию',
                    'callback_data' => 'make_strategy'
                ]
            ],
            [
                [
                    'text' => '🤕 Определить риски',
                    'callback_data' => 'take_risk'
                ]
            ],
            [
                [
                    'text' => '🔥 Дать советы и рекомендации',
                    'callback_data' => 'talk_advice'
                ]
            ],
        ]);
    }
}
