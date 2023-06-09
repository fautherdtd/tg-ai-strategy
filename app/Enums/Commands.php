<?php

namespace App\Enums;

enum Commands: string
{
    case Start = '/start';
    case StopGPT = '/stop_gpt';
    case AboutMe = '/about_me';
    case GetCommands = '/get_commands';
    case StartGPT = '/start_gpt';
}
