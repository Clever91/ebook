<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Group extends Model implements TranslatableContract
{
    use Translatable;

    const STATUS_ACTIVE = 1;
    const STATUS_NO_ACTIVE = 0;

    const TYPE_CATEGORY = "C"; 
    const TYPE_PRODUCT = "P";
    const TYPE_AUTHOR = "A";

    public $translatedAttributes = ['name', 'is_default'];

    protected $fillable = [
        'order_no', 'status', 'updated_by', 'created_by'
    ];

    public function groupcats()
    {
        return $this->hasMany(GroupCategory::class);
    }

    public function grouppros()
    {
        return $this->hasMany(GroupProduct::class);
    }
}
