<?php

namespace App\Models\Admin;

use App\Helpers\Common\GlobalFunc;
use App\Models\Helpers\Base;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\App;

class Author extends Base implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['name', 'bio', 'is_default'];

    protected $fillable = [
        'image_id', 'status', 'deleted', 'updated_by', 'created_by'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class)->where('type', Image::TYPE_AUTHOR);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->where('status', Comment::STATUS_ACTIVE)
            ->whereNull('parent_id');
    }

    public function relations()
    {
        return $this->hasMany(GroupRelation::class, 'related_id', 'id')
            ->where('type', GroupRelation::TYPE_AUTHOR);
    }

    public function getFirstAlphabets()
    {
        $lang = App::getLocale();
        $str = $this->translateorNew($lang)->name;
        if (empty(trim($str)))
            return [];
        $arr = explode(" ", $str);
        $alphabets = [];
        foreach($arr as $a) {
            $key = GlobalFunc::firstUpperStr(trim($a));
            if (empty($key))
                continue;
            $alphabets[$key] = $key;
        }
        return $alphabets;
    }

    public function getImageUrl($size)
    {
        if ($this->hasImage())
            return $this->image->getImageUrl($size);
        return "http://placehold.it/{$size}";
    }

}
