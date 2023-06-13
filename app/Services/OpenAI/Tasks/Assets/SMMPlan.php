<?php

namespace App\Services\OpenAI\Tasks\Assets;

use App\Contracts\BuilderTask;
use App\Services\OpenAI\Tasks\BuilderTasks;

class SMMPlan extends BuilderTasks implements BuilderTask
{

    public function __construct(string $idea)
    {
        $this->placeholder['idea'] = '"'. $idea . '"';
    }

    public function createRole(): string
    {
        return file_get_contents(resource_path('roles/smm.txt'));
    }

    public function createTask(): string
    {
        return file_get_contents(resource_path('task/smm_plan.txt'));
    }

    public function __toString(): string
    {
        $this->placeholder['role'] = $this->createRole();
        $this->placeholder['task'] = $this->createTask();
        return implode(' ', $this->placeholder);
    }
}
