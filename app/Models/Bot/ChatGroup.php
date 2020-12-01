<?php

namespace App\Models\Bot;

use Illuminate\Database\Eloquent\Model;

class ChatGroup extends Model
{
    protected $fillable = [
        'chat_id', 'title', 'all_admin', 'from_id', 'type'
    ];
}
