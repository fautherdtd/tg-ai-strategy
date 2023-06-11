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
    $query = $builder->text(file_get_contents(resource_path('views/templates/how_to_start.html')))
        ->buildText([
            $builder->textKeyboard('💬 Рассказать свою идею / бизнес')
                ->callbackKeyboard('how_to_start')
                ->inlineFull()
        ]);
    dd($query);
});
