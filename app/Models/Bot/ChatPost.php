<?php

namespace App\Models\Bot;

use Illuminate\Database\Eloquent\Model;

class ChatPost extends Model
{
    protected $fillable = [
        'product_id', 'thumbnail', 'caption', 'user_id'
    ];
}
