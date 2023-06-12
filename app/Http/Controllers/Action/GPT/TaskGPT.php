<?php

namespace App\Http\Controllers\Action\GPT;

use App\Enums\GPTAction;
use App\Models\ContextGPT;
use App\Services\OpenAI\ChatGPT;
use App\Services\Sendler;
use App\Services\Telegram\BuilderMessage;

class TaskGPT
{
    public int $chatID;
    public array $tasks = [
        'analysis_market' => 'analysisMarket',
        'make_strategy' => 'makeStrategy',
    ];
    /**
     * @param int $chatID
     */
    public function __construct(int $chatID)
    {
        $this->chatID = $chatID;
    }

    /**
     * @param string $task
     * @return false|mixed
     */
    public function getTask(string $task): mixed
    {
        return call_user_func('self::' . $this->tasks[$task]);
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function analysisMarket(): mixed
    {
        $idea = ContextGPT::where('chat_id', $this->chatID)->first();
        $placeholder = [
            'role' => 'Ты - маркетолог. Твоя задача изучить мою идею, которая написана далее в кавычках',
            'idea' => '"'. $idea->context . '"',
            'tasks' => implode(' ', [
                '1. Проанализируй мне полностью рынок.',
                '2. Исследуй рынок и помоги сегментировать целевую аудиторию.',
            ])
        ];

        $gpt = new ChatGPT();
        $result = $gpt->make(implode(' ', $placeholder));

        $builder = new BuilderMessage($this->chatID);
        return Sendler::send(
          $builder->text($result)->buildText()
        );

    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function makeStrategy(): mixed
    {
        $idea = ContextGPT::where('chat_id', $this->chatID)->first();
        $placeholder = [
            'role' => 'Ты - маркетолог. Твоя задача изучить мою идею, которая написана далее в кавычках',
            'idea' => '"'. $idea->context . '"',
            'tasks' => implode(' ', [
                '1. Изучи всех конкурентов в этой области.',
                '2. Напиши мне подробнее развитие моего бизнеса от 0 до первой прибыли.',
                '3. Опиши мне эту стратегию развития максимально эффективно и подробно.',
            ])
        ];

        $gpt = new ChatGPT();
        $result = $gpt->make(implode(' ', $placeholder));

        $builder = new BuilderMessage($this->chatID);
        return Sendler::send(
          $builder->text($result)->buildText()
        );

    }
}
