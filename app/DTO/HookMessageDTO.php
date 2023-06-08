<?php

namespace App\DTO;

use Illuminate\Http\Request;

class HookMessageDTO
{
    /** @var int $message_id */
    public int $message_id;
    /** @var int $from_id */
    public int $from_id;
    /** @var string $name */
    public string $name;
    /** @var string $username */
    public string $username;
    /** @var string $text */
    public string $text;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->message_id = $request->input('message.message_id');
        $this->from_id = $request->input('message.from.id');
        $this->name = $request->input('message.from.first_name') . ' ' . $request->input('message.from.last_name');
        $this->username = $request->input('message.from.username');
        $this->text = $request->input('message.text');
    }
}
