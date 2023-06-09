<?php

namespace App\Enums;

enum Commands: string
{
    case Start = '/start';
    case StopGPT = '/stop_gpt';
}
