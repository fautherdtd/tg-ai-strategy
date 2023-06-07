<?php

namespace App\Providers;

use App\Http\Facades\MessagesBot;
use Illuminate\Support\ServiceProvider;

class MessageBotServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('messageBot',function(){
            return new MessagesBot();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
