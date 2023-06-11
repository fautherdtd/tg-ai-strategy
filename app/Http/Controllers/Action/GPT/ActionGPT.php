<?php

namespace App\Http\Controllers\Action\GPT;

use App\Models\ContextGPT;
use App\Services\OpenAI\ChatGPT;
use App\Services\Sendler;
use Illuminate\Support\Facades\Redis;

class ActionGPT
{
    public ChatGPT $gpt;

    public function createIdea(string $idea, int $chatID)
    {
        $model = new ContextGPT();
        Redis::del('start_gpt_' . $chatID, true);
        if ($model->where('chat_id', $chatID)->exists()) {
            $text = file_get_contents(resource_path('views/templates/create_idea.html'));
            return Sendler::sendWithMarkup($chatID, $text, array(
                array(
                    array(
                        'text' => 'Button 2',
                        'callback_data' => 'test_2',
                    ),
                ),
                array(
                    array(
                        'text' => 'Button 3',
                        'callback_data' => 'test_3',
                    ),

                    array(
                        'text' => 'Button 4',
                        'callback_data' => 'test_4',
                    ),
                )
            ));

//            [
//                [
//                    [
//                        'text' => '⚠️ Удалить мою идею и предложить новую.',
//                        'callback_data' => 'delete_idea'
//                    ]
//                ],
//                [
//                    [
//                        'text' => '🎯 Посмотреть мой функционал',
//                        'callback_data' => 'commands_idea'
//                    ]
//                ],
//            ]
        } else {
            $text = file_get_contents(resource_path('views/templates/exists_idea.html'));
            $model->chat_id = $chatID;
            $model->context = $idea;
            $model->save();
        }
        return Sendler::sendWithMarkup($chatID, $text, [
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
