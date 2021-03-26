<?php

namespace App\Models\Admin;

use App\Models\Helpers\Base;

class PriceType extends Base
{
    protected $fillable = [
        'name', 'status', 'updated_by', 'created_by'
    ];
}
