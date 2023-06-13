<?php

namespace App\Contracts;

interface BuilderTask
{
    /**
     * @param string $idea
     */
    public function __construct(string $idea);
    /**
     * Create role
     * @return string
     */
    public function createRole(): string;

    /**
     * Create task
     * @return string
     */
    public function createTask(): string;

    /**
     * Create role
     * @return string
     */
    public function __toString(): string;
}
