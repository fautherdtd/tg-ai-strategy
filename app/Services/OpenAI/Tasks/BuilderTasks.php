<?php

namespace App\Services\OpenAI\Tasks;

class BuilderTasks
{
    /**
     * @var array $placeholder
     */
    public array $placeholder = [
        'role' => null,
        'idea' => null,
        'task' => null
    ];

    /**
     * @param string $class
     * @param string $idea
     * @return mixed
     */
    public static function make(string $class, string $idea)
    {
        return new $class($idea);
    }
}
