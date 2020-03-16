<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    protected $fillable = [
        'category_id', 'locale', 'is_default', 'name'
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }
}
