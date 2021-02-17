<?php

namespace App\Models\Admin;

use App\Models\Helpers\Base;
use Illuminate\Support\Str;

class Customer extends Base
{
    const TYPE_TELEGRAM = 1; // telegram customer
    const TYPE_FIREBASE = 2; // firebase customer

    protected $fillable = [
        'uid', 'email', 'photo_url', 'phone_number', 'display_name',
        'status', 'customer_type', 'updated_by'
    ];

    public function displayName()
    {
        if (is_null($this->display_name))
            return "Unknown";

        return $this->display_name;
    }

}
