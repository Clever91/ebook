<?php

namespace App\Models\Bot;

use Illuminate\Database\Eloquent\Model;

class ChatOrderDetail extends Model
{
    protected $fillable = [
        "chat_order_id", "product_id", "quantity", "price"
    ];
}
