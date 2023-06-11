<?php

namespace App\Services\Telegram\Builder;


trait BuilderInlineKeyBoard
{
    /**
     * @var array $button
     */
    public array $button;

    /**
     * @param string $text
     * @return BuilderInlineKeyBoard
     */
    public function textKeyboard(string $text): static
    {
        $this->button['text'] = $text;
        return $this;
    }

    /**
     * @param string $callback
     * @return BuilderInlineKeyBoard
     */
    public function callbackKeyboard(string $callback): static
    {
        $this->button['callback_data'] = $callback;
        return $this;
    }

    public function inlineFull(): array
    {
        return $this->button;
    }
}
