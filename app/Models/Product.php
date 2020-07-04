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

    const DEFAULT_PRODUCT = "/images/no_book.jpg";

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

    public function hasEbook()
    {
        return $this->ebook == self::HAS_EBOOK && !is_null($this->file);
    }

    public function hasImage()
    {
        return !is_null($this->image);
    }

    public function getImage($width = 300, $hight = 300)
    {
        $size = $width . "x" . $hight;
        if ($this->image) {
            $url = $this->image->getImageUrl($size);
            if (File::exists($url))
                return $url;
            $this->image->resizeImage($width, $hight);
            return $this->image->getImageUrl($size);
        }

        return self::DEFAULT_PRODUCT;
    }

    public function generateFilename($extention = "epub")
    {
        return $this->id."_".time().'.'.$extention;
    }

    public function getImageUrl()
    {
        return url('/images/no_book.jpg');
    }
}
