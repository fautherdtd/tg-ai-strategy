<?php

namespace App\Services;

use GuzzleHttp\Client;

class Sendler
{
    public Client $client;

    /**
     * @param int $chatID
     * @param string $text
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function send(int $chatID, string $text)
    {
        $client = new Client();
        $result = $client->get('https://api.telegram.org/bot6142963907:AAFt5WcUagK7qRVQiGRm-lSZo78HY4NeIek/sendMessage',[
            'query' => [
                'chat_id' => $chatID,
                'text' => $text
            ]
        ]);
        return json_decode($result->getBody(), true);
    }

    /**
     * @param int $chatID
     * @param int $messageID
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function delete(int $chatID, int $messageID)
    {
        $client = new Client();
        $result = $client->get('https://api.telegram.org/bot6142963907:AAFt5WcUagK7qRVQiGRm-lSZo78HY4NeIek/deleteMessage',[
            'query' => [
                'chat_id' => $chatID,
                'message_id' => $messageID
            ]
        ]);
        return json_decode($result->getBody(), true);
    }

    /**
     * @param int $chatID
     * @param string $text
     * @param array $buttons
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function sendWithMarkup(int $chatID, string $text, array $buttons, string $mode = 'html')
    {
        $client = new Client();
        $result = $client->get('https://api.telegram.org/bot6142963907:AAFt5WcUagK7qRVQiGRm-lSZo78HY4NeIek/sendMessage',[
            'query' => [
                'chat_id' => $chatID,
                'text' => $text,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [$buttons],
                ]),
                'parse_mode' => $mode
            ]
        ]);
        return json_decode($result->getBody(), true);
    }
}
