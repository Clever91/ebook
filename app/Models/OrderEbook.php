<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderEbook extends Model
{
    const STATE_ORDERED = "O";
    const STATE_PAYED = "P";

    protected $fillable = [
        'order_id', 'customer_id', 'product_id', 'price', 'discount', 'state', 'updated_by'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
