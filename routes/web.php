<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    (new \App\Http\Controllers\Action\MessagesController())->sendWithMarkup(211926346, '123', [
        [
            'text' => 'Тест',
            'callback_data' => 'test_2',
        ],
        [
            'text' => 'Тест 2',
            'callback_data' => 'test_2',

        ]
    ]);
});
