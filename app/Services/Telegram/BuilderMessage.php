<?php

namespace App\Services\Telegram;

use App\Services\Telegram\Assets\InlineKeyboardButtons;
use App\Services\Telegram\Builder\BuilderImage;
use App\Services\Telegram\Builder\BuilderInlineKeyBoard;
use App\Services\Telegram\Builder\BuilderText;

class BuilderMessage
{
    use BuilderText, BuilderImage, BuilderInlineKeyBoard;
    /** @var int $chatID */
    public int $chatID;

    public function __construct(int $chatID)
    {
        $this->chatID = $chatID;
    }

    /**
     * @param string $name
     * @return array
     */
    public function getButton(string $name): array
    {
        $button = new InlineKeyboardButtons();
        return $button->handler($name);
    }

    /**
     * @param array $buttons
     * @return array
     */
    public function buildText(array $buttons = []): array
    {
        $query = [
            'chat_id' => $this->chatID,
            'text' => $this->text,
            'parse_mode' => $this->mode
        ];
        if (!empty($buttons)) {
            $query['reply_markup'] = json_encode(array(
                'inline_keyboard' => [$buttons],
            ));
        }
        return $query;
    }

    /**
     * @param array $buttons
     * @return array
     */
    public function buildImage(array $buttons = []): array
    {
        $query = [
            'chat_id' => $this->chatID,
            'caption' => $this->text,
            'photo' => $this->image,
            'parse_mode' => $this->mode
        ];
        if (!empty($buttons)) {
            $query['reply_markup'] = json_encode(['inline_keyboard' => [$buttons]]);
        }
        return $query;
    }

}
