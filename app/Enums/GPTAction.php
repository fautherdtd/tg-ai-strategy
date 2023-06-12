<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum GPTAction: string
{
    use Values;

    case Analysis = 'analysis_market';
    case Strategy = 'make_strategy';
    case Risk = 'take_risk';
    case Advice = 'talk_advice';
    case CommandsIdea = 'commands_idea';
}
