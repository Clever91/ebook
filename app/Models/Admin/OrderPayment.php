<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'type',
        'currency',
        'paid',
        'json_data',
    ];
}
