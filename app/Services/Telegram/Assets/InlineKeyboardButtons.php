<?php

namespace App\Services\Telegram\Assets;

class InlineKeyboardButtons
{
    /**
     * @var array|string[]
     */
    public array $placeholder = [
        'how_to_start' => 'howToStart',
        'start_create_idea' => 'startCreateIdea',
        'analysis_market' => 'analysisMarket',
        'make_strategy' => 'makeStrategy',
        'take_risk' => 'takeRisk',
        'talk_advice' => 'talkAdvice',
        'commands_idea' => 'commandsIdea',
        'delete_idea' => 'deleteIdea',
    ];

    /**
     * @param string $button
     * @return array
     */
    public function handler(string $button): array
    {
        $function = $this->placeholder[preg_replace('/[^a-zA-Z_]/', '', $button)];
        return call_user_func('self::' . $function);
    }

    /**
     * Button How To Start
     * @return string[]
     */
    public static function howToStart(): array
    {
        return [
            'text' => '❔ Как начать работу',
            'callback_data' => 'how_to_start'
        ];
    }

    /**
     * @return string[]
     */
    public static function startCreateIdea(): array
    {
        return [
            'text' => '💬 Рассказать свою идею / бизнес',
            'callback_data' => 'start_create_idea'
        ];
    }

    /**
     * @return string[]
     */
    public static function analysisMarket(): array
    {
        return [
            'text' => '🚀 Проанализировать рынок',
            'callback_data' => 'analysis_market'
        ];
    }

    /**
     * @return string[]
     */
    public static function makeStrategy(): array
    {
        return [
            'text' => '🎯 Проработать стратегию',
            'callback_data' => 'make_strategy'
        ];
    }

    /**
     * @return string[]
     */
    public static function takeRisk(): array
    {
        return [
            'text' => '🤕 Определить риски',
            'callback_data' => 'take_risk'
        ];
    }

    /**
     * @return string[]
     */
    public static function talkAdvice(): array
    {
        return [
            'text' => '🔥 Дать советы и рекомендации',
            'callback_data' => 'talk_advice'
        ];
    }

    /**
     * @return string[]
     */
    public static function commandsIdea(): array
    {
        return [
            'text' => '🎯 Выбрать задачу для идеи',
            'callback_data' => 'commands_idea'
        ];
    }

    /**
     * @return string[]
     */
    public static function deleteIdea(): array
    {
        return [
            'text' => '⚠️ Удалить идею/бизнес и создать новую',
            'callback_data' => 'delete_idea'
        ];
    }

}
