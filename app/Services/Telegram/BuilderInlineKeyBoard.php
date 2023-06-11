<?php

namespace App\Services\Telegram;

use JetBrains\PhpStorm\ArrayShape;

class BuilderInlineKeyBoard
{
    /**
     * @var array $button
     */
    public array $button;

    /**
     * @param string $text
     * @return BuilderInlineKeyBoard
     */
    public function text(string $text): static
    {
        $this->button['text'] = $text;
        return $this;
    }

    /**
     * @param string $callback
     * @return BuilderInlineKeyBoard
     */
    public function callback(string $callback): static
    {
        $this->button['callback_data'] = $callback;
        return $this;
    }

    public function inlineFull(): array
    {
        return $this->button;
    }
}
