<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    protected $fillable = ['product_id', 'price', 'leftover', 'status', 'updated_by', 'created_by'];
}
