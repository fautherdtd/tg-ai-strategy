<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class BotController extends Controller
{
    public Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'url' => getenv('TELEGRAM_API')
        ]);
    }
}
