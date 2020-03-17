<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupCategory extends Model
{
    protected $fillable = [
        'category_id', 'group_id', 'order_no', 'updated_by', 'created_by'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
