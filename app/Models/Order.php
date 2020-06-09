<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATE_NEW = "N";
    const STATE_PAYED = "P";

    const TYPE_PRODUCT = "P";
    const TYPE_EBOOK = "E";

    protected $fillable = [
        'customer_id', 'total', 'subtotal', 'discount', 'state', 'type', 'updated_by'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
