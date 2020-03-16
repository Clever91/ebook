<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupProduct extends Model
{
    protected $fillable = [
        'product_id', 'group_id', 'order_no', 'updated_by', 'created_by'
    ];
}
