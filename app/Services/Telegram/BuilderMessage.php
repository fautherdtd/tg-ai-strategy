<?php

namespace App\Services\Telegram;

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
            $query['reply_markup'] = json_encode(['inline_keyboard' => [$buttons]]);
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
