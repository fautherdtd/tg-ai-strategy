<?php

namespace App\Http\Controllers\Action\GPT;

use App\Models\ContextGPT;
use App\Services\Sendler;
use App\Services\Telegram\BuilderMessage;

class TaskGPT
{
    public int $chatID;

    /**
     * @param int $chatID
     */
    public function __construct(int $chatID)
    {
        $this->chatID = $chatID;
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function analysisMarket()
    {
        $idea = ContextGPT::where('chat_id', $this->chatID)->pluck('context');
        $placeholder = [
            'preview' => 'У меня есть бизнес -',
            'idea' => $idea,
            'task' => 'Проанализируй мне рынок по моему бизнесу и напиши мне подробнее этот анализ рынка.'
        ];

        $builder = new BuilderMessage($this->chatID);
        $query = $builder->text(implode($placeholder))->buildText();
        return Sendler::send($query);
    }
}
