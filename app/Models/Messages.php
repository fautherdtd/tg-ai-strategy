<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $fillable = [
        'message_id',
        'from',
        'chat',
        'text',
        'type',
        'markup',
        'user_id'
    ];
    public $casts = [
        'from' => 'array',
        'chat' => 'array'
    ];
}
