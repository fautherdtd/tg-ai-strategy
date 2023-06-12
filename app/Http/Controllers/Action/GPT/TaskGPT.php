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
        'take_risk' => 'takeRisk',
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
        $this->processAiForTask('https://tg-ai-strategy.shelit.agency/images/task/analysis.jpg');
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
                '1. Изучи топ 3 конкурентов в этой области.',
                '2. Напиши мне подробнее развитие моего бизнеса от 0 до первой прибыли.',
                '3. Опиши мне эту стратегию развития максимально эффективно и подробно.',
            ])
        ];
        $this->processAiForTask('https://tg-ai-strategy.shelit.agency/images/task/strategy.jpg');
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
    protected function takeRisk(): mixed
    {
        $idea = ContextGPT::where('chat_id', $this->chatID)->first();
        $placeholder = [
            'role' => 'Ты - маркетолог. Твоя задача изучить мою идею, которая написана далее в кавычках',
            'idea' => '"'. $idea->context . '"',
            'tasks' => implode(' ', [
                '1. Определи все риски.',
                '2. Опиши с какими проблемами я могу столкнуться и как их избежать,
                    используя знания всех юридических законов в том числе.',
            ])
        ];
        $this->processAiForTask('https://tg-ai-strategy.shelit.agency/images/task/risk.jpg');
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
    protected function talkAdvice(): mixed
    {
        $idea = ContextGPT::where('chat_id', $this->chatID)->first();
        $placeholder = [
            'role' => 'Ты - маркетолог и специалист по найму. Твоя задача изучить мою идею, которая написана далее в кавычках',
            'idea' => '"'. $idea->context . '"',
            'tasks' => implode(' ', [
                '1. Дай мне советы как маркетолог в этом бизнесе.',
                '2. Я предприниматель и мне нужна команда. Скажи мне какую команду мне надо нанять для старта.',
            ])
        ];
        $this->processAiForTask('https://tg-ai-strategy.shelit.agency/images/task/advice.jpg');
        $gpt = new ChatGPT();
        $result = $gpt->make(implode(' ', $placeholder));
        $builder = new BuilderMessage($this->chatID);
        return Sendler::send(
          $builder->text($result)->buildText()
        );
    }

    /**
     * @param string $cover
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function processAiForTask(string $cover): mixed
    {
        $builder = new BuilderMessage($this->chatID);
        $query = $builder->text(file_get_contents(resource_path('views/templates/proccess_ai_for_task.html')))
            ->image($cover)
            ->buildImage();
        return Sendler::sendImage($query);
    }
}
