<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupCategory extends Model
{
    protected $fillable = [
        'category_id', 'group_id', 'order_no', 'updated_by', 'created_by'
    ];
}
