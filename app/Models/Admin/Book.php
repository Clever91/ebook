<?php

namespace App\Models\Admin;

use App\Models\Helpers\Base;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

class Book extends Base
{
    const LETTER_LATIN = 'L'; // Lotin
    const LETTER_KRILL = 'K'; // Krill

    protected $fillable = [
        'product_id', 'image_id', 'color_id', 'cover_type_id', 'book_detail_id',
        'price', 'leftover', 'cover', 'paper_size', 'letter', 'status',
        'deleted', 'updated_by', 'created_by'
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function color()
    {
        return $this->hasOne(Color::class, 'id', 'color_id');
    }

    public function coverType()
    {
        return $this->hasOne(CoverType::class, 'id', 'cover_type_id');
    }

    public function detail()
    {
        return $this->hasOne(BookDetail::class, 'id', 'book_detail_id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class)->where('type', Image::TYPE_BOOK);
    }

    public function coverLabel($locale = null)
    {
        if (!is_null($this->coverType)) {
            if (is_null($locale))
                return $this->coverType->name;
            else
                return $this->coverType->translateOrNew($locale)->name;
        }
        return null;
    }

    public function letterLabel()
    {
        if (is_null($this->letter) || empty($this->letter))
            return null;
        return self::letterTypes()[$this->letter];
    }

    public function paperSize()
    {
        return $this->paper_size;
    }

    public function colorLabel()
    {
        if (!is_null($this->color)) {
            return $this->color->name;
        }
        return null;
    }

    public function getBtnLabel($locale = null)
    {
        $txt = "";
        if (!is_null($this->color))
            $txt .= $this->color->short;
        if (!empty($txt))
            $txt .= " | ";
        if (!empty($this->paperSize()))
            $txt .= $this->paperSize();
        if (!empty($txt))
            $txt .= " | ";
        if (!empty($this->letterLabel()))
            $txt .= $this->letterLabel();
        if (!empty($txt))
            $txt .= " | ";
        if (!is_null($this->coverType))
            $txt .= $this->coverLabel($locale);
        return $txt;
    }

    public static function coverTypes()
    {
        return CoverType::where('status', CoverType::STATUS_ACTIVE)->get();
    }

    public static function letterTypes()
    {
        return [
            self::LETTER_KRILL => Lang::get('admin.letter_krill'),
            self::LETTER_LATIN => Lang::get('admin.letter_latin'),
        ];
    }

    public static function colorTypes()
    {
        return Color::where('status', Color::STATUS_ACTIVE)->get();
    }

    public function getDescription($caption, $locale = "ru")
    {
        // author
        if (!is_null($this->product->author))
            $caption .= "*".Lang::get('bot.author').":* _" . $this->product->author->translateorNew($locale)->name . "_\n";
        // cover type
        if (!is_null($this->coverType))
            $caption .= "*".Lang::get('bot.cover_type').":* _" . $this->coverType->translateorNew($locale)->name . "_\n";
        // paper size
        if (!empty($this->paperSize()))
            $caption .= "*".Lang::get('bot.paper_size').":* _" . $this->paperSize() . "_\n";
        // letter
        if (!empty($this->letter))
            $caption .= "*".Lang::get('bot.letter').":* _" . $this->letterLabel() . "_\n";
        // color
        if (!is_null($this->color))
            $caption .= "*".Lang::get('bot.color').":* _" . $this->color->short . "_\n";

        return $caption;
    }
}
