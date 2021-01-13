<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AudioBook extends Model
{
    protected $fillable = ['product_id', 'price', 'file_id', 'status', 'updated_by', 'created_by'];
}
