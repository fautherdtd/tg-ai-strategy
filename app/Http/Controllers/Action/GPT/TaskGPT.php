<?php

namespace App\Http\Controllers\Action\GPT;

use App\Enums\TaskGPT\TaskClasses;
use App\Models\ContextGPT;
use App\Services\OpenAI\SendlerGPT;
use App\Services\OpenAI\Tasks\BuilderTasks;
use App\Services\Sendler;
use App\Services\Telegram\BuilderMessage;
use Illuminate\Support\Facades\Redis;

class TaskGPT
{
    /** @var int $chatID */
    public int $chatID;
    /** @var string $idea */
    public string $idea;
    public SendlerGPT $sendlerGPT;

    public array $tasks = [
        'analysis_market' => 'analysisMarket',
        'make_strategy' => 'makeStrategy',
        'take_risk' => 'takeRisk',
        'talk_advice' => 'talkAdvice',
        'smm_plan' => 'smmPlan',
    ];
    /**
     * @param int $chatID
     */
    public function __construct(int $chatID)
    {
        $this->sendlerGPT = new SendlerGPT();
        $this->chatID = $chatID;
        $this->idea = ContextGPT::where('chat_id', $this->chatID)->first();
    }

    /**
     * @param string $task
     * @return false|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTask(string $task): mixed
    {
        $this->processAiForTask("https://tg-ai-strategy.shelit.agency/images/task/{$task}.jpg");
        return call_user_func('self::' . $this->tasks[$task]);
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function analysisMarket(): mixed
    {
        $placeholder = BuilderTasks::make(
            TaskClasses::AnalysisMarket->value,
            $this->idea
        );
        $result = $this->sendlerGPT->make($placeholder);
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
        $placeholder = BuilderTasks::make(
            TaskClasses::StrategyTask->value,
            $this->idea
        );
        $result = $this->sendlerGPT->make($placeholder);
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
        $placeholder = BuilderTasks::make(
            TaskClasses::TakeRisk->value,
            $this->idea
        );
        $result = $this->sendlerGPT->make($placeholder);
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
        $placeholder = BuilderTasks::make(
            TaskClasses::TalkAdvice->value,
            $this->idea
        );
        $result = $this->sendlerGPT->make($placeholder);
        $builder = new BuilderMessage($this->chatID);
        return Sendler::send(
          $builder->text($result)->buildText()
        );
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function smmPlan(): mixed
    {
        $placeholder = BuilderTasks::make(
            TaskClasses::SmmPlan->value,
            $this->idea
        );
        $result = $this->sendlerGPT->make($placeholder);
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
        $query = $builder
            ->text(file_get_contents(resource_path('views/templates/process_ai_for_task.html')))
            ->image($cover)
            ->buildImage();
        return Sendler::sendImage($query);
    }
}
