<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'item_id', 'item_type', 'made_price',
        'sold_price', 'quantity', 'discount', 'total_price'
    ];
}
