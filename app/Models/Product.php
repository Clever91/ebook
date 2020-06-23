<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends Base implements TranslatableContract
{
    use Translatable;

    const HAS_EBOOK = 1;
    const HAS_NOT_EBOOK = 0;

    public $translatedAttributes = ['name', 'description', 'is_default'];

    protected $fillable = [
        'category_id', 'author_id', 'price', 'eprice', 'ebook', 'status', 'updated_by', 'created_by'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

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
