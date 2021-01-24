<?php

namespace App\Models\Admin;

use App\Models\Helpers\Base;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

class Book extends Base
{
    const COVER_HARD = 'H'; // Hard
    const COVER_SOFT = 'S'; // Soft

    const LETTER_LATIN = 'L'; // Lotin
    const LETTER_KRILL = 'K'; // Krill

    protected $fillable = ['product_id', 'color_id', 'cover_type_id', 'price', 'leftover', 'cover',
    'paper_size', 'letter', 'status', 'deleted', 'updated_by', 'created_by'];

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

    public function coverLabel()
    {
        if (!is_null($this->coverType))
            return $this->coverType->translateOrNew(App::getLocale())->name;
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
}
