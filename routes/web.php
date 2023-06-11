<?php

use App\Enums\Commands;
use App\Services\Telegram\BuilderInlineKeyBoard;
use App\Services\Telegram\BuilderMessage;
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
    $builder = new BuilderMessage(1);

    $button = $builder->textKeyboard('test')->callbackKeyboard('callback')->inlineFull();
    $button2 = $builder->textKeyboard('test2')->callbackKeyboard('callback2')->inlineFull();
    $builder->text('test');
    dd($builder->buildText([$button, $button2]));

});
