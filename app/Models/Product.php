<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\File;

class Product extends Base implements TranslatableContract
{
    use Translatable;

    const HAS_EBOOK = 1;
    const HAS_NOT_EBOOK = 0;

    const STATUS_ACTIVE = 1;
    const STATUS_NO_ACTIVE = 0;

    public $translatedAttributes = ['name', 'description', 'is_default'];

    protected $fillable = [
        'category_id', 'author_id', 'file_id', 'image_id', 
        'price', 'eprice', 'ebook', 'status', 'updated_by', 'created_by'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function file()
    {
        return $this->belongsTo(Files::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class)->where('type', Image::TYPE_PRODUCT);
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
            ->where('type', GroupRelation::TYPE_PRODUCT);
    }

    public function hasEbook()
    {
        return $this->ebook == self::HAS_EBOOK && !is_null($this->file);
    }

    public function isBought($customer_id)
    {
        if (is_null($customer_id))
            return 0;

        $ebook = OrderEbook::where([
            'customer_id' => $customer_id,
            'product_id' => $this->id,
            'state' => OrderEbook::STATE_PAYED
        ])->first();

        return is_null($ebook) ? 0 : 1;
    }
}
