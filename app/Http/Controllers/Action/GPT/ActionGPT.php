<?php

namespace App\Http\Controllers\Action\GPT;

use App\Http\Controllers\Builders;
use App\Models\ContextGPT;
use App\Services\OpenAI\ChatGPT;
use App\Services\Sendler;
use App\Services\Telegram\BuilderInlineKeyBoard;
use Illuminate\Support\Facades\Redis;

class ActionGPT
{
    use Builders;

    public ChatGPT $gpt;

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

        $text = file_get_contents(resource_path('views/templates/exists_idea.html'));
        $model->chat_id = $chatID;
        $model->context = $idea;
        $model->save();

        return Sendler::sendWithMarkup($chatID, $text, [
            $this->builderInlineKeyboard()
                ->text('🚀 Проанализировать рынок')
                ->callback('analysis_market')
                ->inlineFull(),
            $this->builderInlineKeyboard()
                ->text('🎯 Проработать стратегию')
                ->callback('make_strategy')
                ->inlineFull(),
            $this->builderInlineKeyboard()
                ->text('🤕 Определить риски')
                ->callback('take_risk')
                ->inlineFull(),
            $this->builderInlineKeyboard()
                ->text('🔥 Дать советы и рекомендации')
                ->callback('talk_advice')
                ->inlineFull(),
        ]);
    }

    /**
     * @param int $chatID
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function existIdea(int $chatID): mixed
    {
        $text = file_get_contents(resource_path('views/templates/exist_idea.html'));
        return Sendler::sendWithMarkup($chatID, $text, [
            $this->builderInlineKeyboard()->text('⚠️ Удалить мою идею и предложить новую.')
                ->callback('delete_idea')
                ->inlineFull(),
            $this->builderInlineKeyboard()
                ->text('🎯 Посмотреть мой функционал')
                ->callback('commands_idea')
                ->inlineFull()
        ]);
    }
}
