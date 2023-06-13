<?php

namespace App\Services\OpenAI\Tasks\Assets;

use App\Contracts\BuilderTask;
use App\Services\OpenAI\Tasks\BuilderTasks;

class StrategyTask extends BuilderTasks implements BuilderTask
{
    public function __construct(string $idea)
    {
        $this->placeholder['idea'] = '"'. $idea . '"';
    }
    /**
     * @return string
     */
    public function createRole(): string
    {
        return file_get_contents(resource_path('roles/marketing.txt'));
    }

    /**
     * @return string
     */
    public function createTask(): string
    {
        return file_get_contents(resource_path('task/make_strategy.txt'));
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $this->placeholder['role'] = $this->createRole();
        $this->placeholder['task'] = $this->createTask();
        return implode(' ', $this->placeholder);
    }
}
