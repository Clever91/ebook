<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Category extends Base implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['name', 'is_default'];

    protected $fillable = [
        'order_no', 'status', 'updated_by', 'created_by'
    ];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->where('status', Comment::STATUS_ACTIVE)
            ->whereNull('parent_id');
    }
    
    public function getImageUrl()
    {
        return url('/images/no_book.jpg');
    }

}
