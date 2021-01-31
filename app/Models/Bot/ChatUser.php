<?php

namespace App\Models\Bot;

use Illuminate\Database\Eloquent\Model;

class ChatUser extends Model
{
    protected $fillable = [
        'chat_id', 'first_name', 'last_name', 'language_code',
        'locale', 'username',
    ];
}
