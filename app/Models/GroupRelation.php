<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupRelation extends Model
{
    const TYPE_CATEGORY = "C";
    const TYPE_PRODUCT = "P";
    const TYPE_AUTHOR = "A";

    protected $fillable = [
        'related_id', 'group_id', 'type', 'order_no', 'updated_by', 'created_by'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'related_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'related_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'related_id', 'id');
    }
}
