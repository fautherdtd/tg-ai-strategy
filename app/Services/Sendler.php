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
    public static function send(int $chatID, string $text, string $mode = 'html')
    {
        $client = new Client();
        $query = [
            'chat_id' => $chatID,
            'text' => $text,
        ];
        if ($mode === 'html') {
            $query[] = [
                'parse_mode' => $mode
            ];
        }
        $result = $client->get('https://api.telegram.org/bot6142963907:AAFt5WcUagK7qRVQiGRm-lSZo78HY4NeIek/sendMessage',[
            'query' => $query
        ]);
        return json_decode($result->getBody(), true);
    }

    /**
     * @param int $chatID
     * @param string $text
     * @param string $image
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function sendImageAndText(int $chatID, string $text, string $image)
    {
        $client = new Client();
        $result = $client->get('https://api.telegram.org/bot6142963907:AAFt5WcUagK7qRVQiGRm-lSZo78HY4NeIek/sendPhoto',[
            'query' => [
                'chat_id' => $chatID,
                'caption' => $text,
                'photo' => $image
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
    public static function sendWithMarkup(int $chatID, string $text, array $buttons, string $mode = 'html'): mixed
    {
        $client = new Client();
        $result = $client->get('https://api.telegram.org/bot6142963907:AAFt5WcUagK7qRVQiGRm-lSZo78HY4NeIek/sendMessage',[
            'query' => [
                'chat_id' => $chatID,
                'text' => $text,
                'reply_markup' => json_encode([
                    'inline_keyboard' => array(
                        array(
                            array(
                                'text' => 'Button 2',
                                'callback_data' => 'test_2',
                            ),
                        ),
                        array(
                            array(
                                'text' => 'Button 3',
                                'callback_data' => 'test_3',
                            ),

                            array(
                                'text' => 'Button 4',
                                'callback_data' => 'test_4',
                            ),
                        )
                    )
                ]),
                'parse_mode' => $mode
            ]
        ]);
        return json_decode($result->getBody(), true);
    }

    /**
     * @param int $chatID
     * @param int $message_id
     * @param array $buttons
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function editMessageReplyMarkup(int $chatID, int $message_id, array $buttons): mixed
    {
        $client = new Client();
        $result = $client->get('https://api.telegram.org/bot6142963907:AAFt5WcUagK7qRVQiGRm-lSZo78HY4NeIek/sendMessage',[
            'query' => [
                'chat_id' => $chatID,
                'message_id' => $message_id,
                'reply_markup' => json_encode([
                    'inline_keyboard' => $buttons,
                ]),
            ]
        ]);
        return json_decode($result->getBody(), true);
    }
}
