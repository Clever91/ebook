<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'item_id', 'item_type', 'price',
        'quantity', 'discount', 'total_price'
    ];
}
