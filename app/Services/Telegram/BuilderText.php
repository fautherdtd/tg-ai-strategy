<?php

namespace App\Services\Telegram;

trait BuilderText
{
    public string $text;
    public string $mode;

    /**
     * @param string $text
     * @return $this
     */
    public function text(string $text): static
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @param string $mode
     * @return $this
     */
    public function mode(string $mode = 'html'): static
    {
        $this->mode = $mode;
        return $this;
    }
}
