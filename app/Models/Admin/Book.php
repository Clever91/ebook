<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['product_id', 'price', 'leftover', 'cover',
    'size', 'letter', 'color', 'status', 'updated_by', 'created_by'];
}
