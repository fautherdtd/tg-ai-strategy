<?php

namespace App\Services\Telegram;

trait BuilderImage
{
    public string $image;

    /**
     * @param string $src
     * @return $this
     */
    public function image(string $src): static
    {
        $this->image = $src;
        return $this;
    }
}
