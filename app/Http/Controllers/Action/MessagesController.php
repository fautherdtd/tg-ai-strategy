<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\BotController;
use App\Http\Controllers\Controller;

class MessagesController extends BotController
{
    /**
     * @param int $chatID
     * @param string $text
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(int $chatID, string $text)
    {
        $result = $this->client->get('https://api.telegram.org/bot6142963907:AAFt5WcUagK7qRVQiGRm-lSZo78HY4NeIek/sendMessage',[
            'query' => [
                'chat_id' => $chatID,
                'text' => urlencode($text)
            ]
        ]);
        return json_decode($result->getBody(), true);
    }

    /**
     * @param int $chatID
     * @param int $messageID
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(int $chatID, int $messageID)
    {
        $result = $this->client->get('https://api.telegram.org/bot6142963907:AAFt5WcUagK7qRVQiGRm-lSZo78HY4NeIek/deleteMessage',[
            'query' => [
                'chat_id' => $chatID,
                'message_id' => $messageID
            ]
        ]);
        dd(json_decode($result->getBody(), true));
    }

    /**
     * @param int $chatID
     * @param string $text
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendWithMarkup(int $chatID, string $text, array $buttons)
    {
        $result = $this->client->get('https://api.telegram.org/bot6142963907:AAFt5WcUagK7qRVQiGRm-lSZo78HY4NeIek/sendMessage',[
            'query' => [
                'chat_id' => $chatID,
                'text' => urlencode($text),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [$buttons],
                ]),
            ]
        ]);
        dd(json_decode($result->getBody(), true));
    }
}
