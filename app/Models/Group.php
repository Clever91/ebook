<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Group extends Base implements TranslatableContract
{
    use Translatable;

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

    public function deleteRelations()
    {
        $relations = $this->relations()->get();

        foreach($relations as $relation) {
            $relation->delete();
        }
    }
}
