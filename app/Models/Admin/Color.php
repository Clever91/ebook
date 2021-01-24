<?php

namespace App\Models\Admin;

use App\Models\Helpers\Base;
use Illuminate\Database\Eloquent\Model;

class Color extends Base
{
    protected $fillable = ['name', 'short', 'hex', 'status'];
}
