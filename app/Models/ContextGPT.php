<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContextGPT extends Model
{
    protected $table = 'context_gpt';
    protected $fillable = [
        'chat_id',
        'context'
    ];
}
