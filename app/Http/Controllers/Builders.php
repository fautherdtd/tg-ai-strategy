<?php

namespace App\Http\Controllers;

use App\Services\Telegram\Builder\BuilderInlineKeyBoard;

trait Builders
{
    /**
     * @return BuilderInlineKeyBoard
     */
   public function builderInlineKeyboard(): BuilderInlineKeyBoard
    {
        return new BuilderInlineKeyBoard();
    }
}
