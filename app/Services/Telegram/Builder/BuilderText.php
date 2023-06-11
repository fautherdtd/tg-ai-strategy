<?php

namespace App\Services\Telegram\Builder;

trait BuilderText
{
    public string $text;
    public string $mode = 'html';

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
