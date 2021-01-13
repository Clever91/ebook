<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = [
        'customer_id', 'object_id', 'type'
    ];

    public function types()
    {
        return [
            'P', 'C', 'A'
        ];
    }
}
