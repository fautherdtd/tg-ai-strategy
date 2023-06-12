<?php

namespace App\Http\Controllers\Action\GPT;

use App\Enums\GPTAction;
use App\Models\ContextGPT;
use App\Services\Sendler;
use App\Services\Telegram\BuilderMessage;

class TaskGPT
{
    public int $chatID;
    public array $tasks = [
        'analysis_market' => 'analysisMarket'
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
            'preview' => 'У меня есть бизнес -',
            'idea' => $idea->context,
            'task' => 'Проанализируй мне рынок по моему бизнесу и напиши мне подробнее этот анализ рынка.'
        ];

        $builder = new BuilderMessage($this->chatID);
        $query = $builder->text(implode($placeholder))->buildText();
        return Sendler::send($query);
    }
}
