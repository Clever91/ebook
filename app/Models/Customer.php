<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Customer extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_NO_ACTIVE = 0;

    protected $fillable = [
        'uid', 'email', 'photo_url', 'phone_number', 'display_name', 'status', 'updated_by'
    ];

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

}
