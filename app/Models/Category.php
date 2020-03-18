<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Category extends Model implements TranslatableContract
{
    use Translatable;

    const STATUS_ACTIVE = 1;
    const STATUS_NO_ACTIVE = 0;

    public $translatedAttributes = ['name', 'is_default'];

    protected $fillable = [
        'order_no', 'status', 'updated_by', 'created_by'
    ];

    public function getImageUrl()
    {
        return url('/images/no_book.jpg');
    }
}
