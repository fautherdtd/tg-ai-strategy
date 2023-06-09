<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum Commands: string
{
    use Values;

    case Start = '/start';
    case StopGPT = '/stop_gpt';
    case AboutMe = '/about_me';
    case Menu = '/menu';
    case StartGPT = '/start_gpt';
}
