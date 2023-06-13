<?php

use App\Enums\GPTAction;
use App\Enums\TaskGPT\TaskClasses;
use App\Services\OpenAI\Tasks\BuilderTasks;
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
//    $builder = new BuilderTasks();
//    return $builder->make();

    return BuilderTasks::make(TaskClasses::TalkAdvice->value, 'text 123');
});
