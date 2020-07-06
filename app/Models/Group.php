<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Group extends Base implements TranslatableContract
{
    use Translatable;

    const STATUS_ACTIVE = 1;
    const STATUS_NO_ACTIVE = 0;

    public $translatedAttributes = ['name', 'is_default'];

    protected $fillable = [
        'order_no', 'status', 'image_id', 'deleted', 'updated_by', 'created_by'
    ];

    public function relations()
    {
        return $this->hasMany(GroupRelation::class, 'group_id', 'id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class)->where('type', Image::TYPE_GROUP);
    }
}
