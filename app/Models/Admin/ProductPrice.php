<?php

namespace App\Models\Admin;

use App\Models\Helpers\Base;

class ProductPrice extends Base
{
    const TYPE_BOOK = "B"; // book
    const TYPE_EBOOK = "E"; // ebook
    const TYPE_AUDIO = "A"; // audio
    const TYPE_GOOD = "G"; // good

    protected $fillable = [
        'price_type_id',
        'object_id',
        'object_type',
        'price',
        'status',
        'updated_by',
        'created_by'
    ];
}
