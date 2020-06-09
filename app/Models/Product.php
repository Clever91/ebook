<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements TranslatableContract
{
    use Translatable;

    const STATUS_ACTIVE = 1;
    const STATUS_NO_ACTIVE = 0;

    const HAS_EBOOK = 1;
    const HAS_NOT_EBOOK = 0;

    public $translatedAttributes = ['name', 'description', 'is_default'];

    protected $fillable = [
        'category_id', 'author_id', 'price', 'eprice', 'ebook', 'status', 'updated_by', 'created_by'
    ];

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

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function getImageUrl()
    {
        return url('/images/no_book.jpg');
    }
}
