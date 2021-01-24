<?php

namespace App\Models\Admin;

use App\Models\Helpers\Base;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class CoverType extends Base implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['name', 'is_default'];

    protected $fillable = [
        'status', 'updated_by', 'created_by'
    ];
}
