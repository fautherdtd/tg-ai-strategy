<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\BotController;
use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SettingsController extends BotController
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index()
    {
        $result = $this->client->get('https://api.telegram.org/bot6142963907:AAFt5WcUagK7qRVQiGRm-lSZo78HY4NeIek/sendMessage',[
            'query' => [
                'chat_id' => 211926346,
                'text' => urlencode('Test')
            ]
        ]);
        dd(json_decode($result->getBody(), true));
    }
}
