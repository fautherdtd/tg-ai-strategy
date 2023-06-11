<?php

use App\Enums\Commands;
use App\Services\Telegram\BuilderInlineKeyBoard;
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
    $builder = new BuilderInlineKeyBoard();

    $test1 = $builder
        ->text('test1')
        ->callback('call1')->inlineFull();
    $test2 = $builder
        ->text('test2')
        ->callback('call2')->inlineFull();
    dd($test2);

});
