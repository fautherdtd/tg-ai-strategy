<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum Commands: string
{
    use Values;

    case Start = '/start';
    case Menu = '/menu';
    case AboutMe = '/about_me';
    case StartGPT = '/start_gpt';
    case StopGPT = '/stop_gpt';
}
