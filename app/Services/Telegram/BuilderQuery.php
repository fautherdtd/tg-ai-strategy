<?php

namespace App\Services\Telegram;

use App\Models\User;

class BuilderQuery
{
    public string $text;
    public string $mode;
    public int $chatID;
    public array $button;

    /**
     * @param string $text
     * @return BuilderQuery
     */
    public function text(string $text): BuilderQuery
    {
        $this->text = $text;
    }

    /**
     * @param string $text
     * @return BuilderQuery
     */
    public function textPath(string $path): BuilderQuery
    {
        $this->text = file_get_contents(resource_path($path));
    }

    /**
     * @param string $text
     * @return BuilderQuery
     */
    public function mode(string $mode): BuilderQuery
    {
        $this->mode = $mode;
    }

    /**
     * @param array $btn
     * @param ...$params
     * @return BuilderQuery
     */
    public function button(array $btn, ...$params): BuilderQuery
    {
        $this->button = [
            'text' => $btn['text'],
            'callback_data' => $btn['command'],
            $params
        ];
    }

    /**
     * @param int $chatID
     * @return BuilderQuery
     */
    public function chatID(int $chatID): BuilderQuery
    {
        $this->chatID = $chatID;
    }

    public function make()
    {
        $query =  ['chat_id' => $this->chatID];
        if (empty($this->text)) {
            $query[] = [
                'text' => $this->text
            ];
        }
        if (empty($this->mode)) {
            $query[] = [
                'parse_mode' => $this->mode
            ];
        }
        if (empty($this->button)) {
            $query[] = [
                'reply_markup' => json_encode([
                    'inline_keyboard' => [$this->button],
                ]),
            ];
        }
    }

}
