<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupProduct extends Model
{
    protected $fillable = [
        'product_id', 'group_id', 'order_no', 'updated_by', 'created_by'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
