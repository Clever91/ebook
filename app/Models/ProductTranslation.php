<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    protected $fillable = [
        'product_id', 'locale', 'is_default', 'name', 'description'
    ];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
