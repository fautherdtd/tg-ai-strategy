<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum Commands: string
{
    use Values;

    case Start = '/start';
    case HowToStart = '/how_to_start';
    case AboutMe = '/about_me';
    case createIdeaForGPT = '/create_idea';
    case DeleteIdea = '/delete_idea';
}
