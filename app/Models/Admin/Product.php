<?php

namespace App\Models\Admin;

use App\Models\Helpers\Base;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class Product extends Base implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['name', 'description', 'is_default'];

    protected $fillable = [
        'category_id', 'author_id', 'image_id', 'status', 'updated_by', 'created_by'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
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

    public function book()
    {
        return Book::where([
            'product_id' => $this->id,
            'deleted' => Book::NO_DELETED,
        ])->orderBy('price', 'asc')->first();
    }

    public function books($state = null)
    {
        if (!is_null($state)) {
            return Book::where([
                'product_id' => $this->id,
                'status' => self::STATUS_ACTIVE,
                'deleted' => self::NO_DELETED,
            ])->get();
        }
        return Book::where([
            'product_id' => $this->id,
            'deleted' => self::NO_DELETED,
        ])->get();
    }

    public function ebook()
    {
        return Ebook::where('product_id', $this->id)->first();
    }

    public function bookPrice()
    {
        if (!is_null($this->book()))
            return $this->book()->getPrice();

        return 0;
    }

    public function ebookPrice()
    {
        if (!is_null($this->ebook()))
            return $this->ebook()->price;

        return 0;
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

    public function authorName()
    {
        if (is_null($this->author))
            return __('admin.no');

        return $this->author->translateOrNew(App::getLocale())->name;
    }

    public function getBookBy($column)
    {
        $books = DB::table('books')
        ->select($column, DB::raw('MAX(id) as book_id'))
        ->where([
            ['product_id', '=', $this->id],
            ['deleted', '=', self::NO_DELETED],
            ['status', '=', self::STATUS_ACTIVE],
            [$column, '<>', 'NULL'],
            [$column, '<>', ''],
        ])
        ->groupBy($column)
        ->get();
        return $books;
    }
}
