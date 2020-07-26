<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Category extends Base implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['name', 'is_default'];

    protected $fillable = [
        'order_no', 'status', 'image_id', 'deleted', 'updated_by', 'created_by'
    ];

    public function image()
    {
        return $this->belongsTo(Image::class)->where('type', Image::TYPE_CATEGORY);
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
            ->where('type', GroupRelation::TYPE_CATEGORY);
    }

}
