<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_NO_ACTIVE = 0;

    protected $fillable = [
        'name', 'bio', 'status', 'updated_by', 'created_by'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
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
