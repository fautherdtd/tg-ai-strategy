<?php

namespace App\DTO;

use Illuminate\Http\Request;

class HookCallbackDTO
{
    /** @var int $callback_id */
    public int $callback_id;
    /** @var int $message_id */
    public int $message_id;
    /** @var int $from_id */
    public int $from_id;
    /** @var string $name */
    public string $name;
    /** @var string $username */
    public string $username;
    /** @var array $markup */
    public array $markup;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->message_id = $request->input('callback_query.message.message_id');
        $this->from_id = $request->input('callback_query.from.id');
        $this->name = $request->input('callback_query.from.first_name') . ' ' . $request->input('message.from.last_name');
        $this->username = $request->input('callback_query.from.username');
        $this->markup = $request->input('callback_query.message.reply_markup');
        $this->data = $request->input('callback_query.data');
    }

    /**
     * @return array
     */
    public function parseMarkup(): array
    {
        $actions = [];
        foreach ($this->markup as $markup) {
            foreach ($markup[0] as $item) {
                $actions[] = $item['callback_data'];
            }
        }
        return $actions;
    }
}
