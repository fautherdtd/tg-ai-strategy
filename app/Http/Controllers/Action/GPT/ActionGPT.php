<?php

namespace App\Http\Controllers\Action\GPT;

use App\Models\ContextGPT;
use App\Services\OpenAI\ChatGPT;
use App\Services\Sendler;
use App\Services\Telegram\BuilderMessage;
use Illuminate\Support\Facades\Redis;

class ActionGPT
{
    public ChatGPT $gpt;

    /**
     * @param int $chatID
     * @param string $message
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function finishedCreateIdea(int $chatID, string $message): mixed
    {
        Redis::del('start_gpt_' . $chatID, true);
        if (ContextGPT::where('chat_id', $chatID)->exists()) {
            return $this->existIdea($chatID);
        }
        $model = ContextGPT::create([
            'chat_id' => $chatID,
            'context' => $message
        ]);

        $builder = new BuilderMessage($chatID);
        $query = $builder->text(file_get_contents(resource_path('views/templates/finished_create_idea.html')))
            ->buildText([
                $builder->textKeyboard('🚀 Проанализировать рынок')
                    ->callbackKeyboard('analysis_market')
                    ->inlineFull()
            ]);
        return Sendler::send($query);
    }

    /**
     * @param string $idea
     * @param int $chatID
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createIdea(string $idea, int $chatID): mixed
    {
        $model = new ContextGPT();
        Redis::del('start_gpt_' . $chatID, true);

        // Если идея уже сохранена
        if ($model->where('chat_id', $chatID)->exists()) {
            return $this->existIdea($chatID);
        }
        // Сохраняем идею в БД
        $model->chat_id = $chatID;
        $model->context = $idea;
        $model->save();

        // Создаем запрос
        $builder = new BuilderMessage($chatID);
        $query = $builder->text(file_get_contents(resource_path('views/templates/create_idea.html')))
            ->buildText([
                $builder->textKeyboard('🚀 Проанализировать рынок')
                ->callbackKeyboard('analysis_market')
                ->inlineFull()
            ]);
        return Sendler::send($query);

//        [
//            $builder->textKeyboard('🚀 Проанализировать рынок')
//                ->callbackKeyboard('analysis_market')
//                ->inlineFull()
//        ],
//                [
//                    $builder->textKeyboard('🎯 Проработать стратегию')
//                        ->callbackKeyboard('make_strategy')
//                        ->inlineFull()
//                ],
//                [
//                    $builder->textKeyboard('🤕 Определить риски')
//                        ->callbackKeyboard('take_risk')
//                        ->inlineFull()
//                ],
//                [
//                    $builder->textKeyboard('🔥 Дать советы и рекомендации')
//                        ->callbackKeyboard('talk_advice')
//                        ->inlineFull()
//                ],
    }

    /**
     * @param int $chatID
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function existIdea(int $chatID): mixed
    {
        $builder = new BuilderMessage($chatID);
        $query = $builder->text(file_get_contents(resource_path('views/templates/exist_idea.html')))
            ->buildText([
                $builder->textKeyboard('⚠️ Удалить мою идею и предложить новую.')
                ->callbackKeyboard('delete_idea')
                ->inlineFull()
            ]);
        return Sendler::send($query);
//        [
//            $builder->textKeyboard('⚠️ Удалить мою идею и предложить новую.')
//                ->callbackKeyboard('delete_idea')
//                ->inlineFull()
//        ],
//                [
//                    $builder->textKeyboard('🎯 Посмотреть мой функционал')
//                        ->callbackKeyboard('commands_idea')
//                        ->inlineFull()
//                ],
    }
}
