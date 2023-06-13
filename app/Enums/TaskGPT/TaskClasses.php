<?php

namespace App\Enums\TaskGPT;

enum TaskClasses: string
{
    case StrategyTask = 'App\Services\OpenAI\Tasks\Assets\StrategyTask';
    case AnalysisMarket = 'App\Services\OpenAI\Tasks\Assets\AnalysisMarket';
    case TakeRisk = 'App\Services\OpenAI\Tasks\Assets\TakeRisk';
    case TalkAdvice = 'App\Services\OpenAI\Tasks\Assets\TalkAdvice';
    case SmmPlan = 'App\Services\OpenAI\Tasks\Assets\SmmPlan';
}
