<?php

namespace App\Models\Admin;

use App\Models\Helpers\Base;

class Author extends Base
{
    protected $fillable = [
        'name', 'bio', 'image_id', 'status', 'deleted', 'updated_by', 'created_by'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class)->where('type', Image::TYPE_AUTHOR);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->where('status', Comment::STATUS_ACTIVE)
            ->whereNull('parent_id');
    }

    public function relations()
    {
        return $this->hasMany(GroupRelation::class, 'related_id', 'id')
            ->where('type', GroupRelation::TYPE_AUTHOR);
    }

}
