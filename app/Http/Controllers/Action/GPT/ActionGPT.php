<?php

namespace App\Http\Controllers\Action\GPT;

use App\Models\ContextGPT;
use App\Services\OpenAI\SendlerGPT;
use App\Services\Sendler;
use App\Services\Telegram\BuilderMessage;
use Illuminate\Support\Facades\Redis;

class ActionGPT
{
    public SendlerGPT $gpt;

    /**
     * @param int $chatID
     * @param string $message
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function finishedCreateIdea(int $chatID, string $message): mixed
    {
        Redis::del('create_idea_' . $chatID, true);
        if (ContextGPT::where('chat_id', $chatID)->exists()) {
            return $this->existIdea($chatID);
        }
        $model = ContextGPT::create([
            'chat_id' => $chatID,
            'context' => $message
        ]);

        $builder = new BuilderMessage($chatID);
        $query = $builder->text(file_get_contents(resource_path('views/templates/finished_create_idea.html')))
            ->buildText(
                [$builder->getButton('analysis_market')],
                [$builder->getButton('make_strategy')],
                [$builder->getButton('take_risk')],
                [$builder->getButton('talk_advice')],
            );
        return Sendler::send($query);
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
            ->buildText(
                [$builder->getButton('delete_idea')],
                [$builder->getButton('commands_idea')],
            );
        return Sendler::send($query);
    }
}
