<?php

namespace App\Enums;

enum InlineKeyboards: string
{
    case AboutMe = 'about_me';
    case GetCommands = 'get_commands';
    case StartGPT = 'start_gpt';
    case StopGPT = 'stop_gpt';
}
