<?php

namespace App\Models\Admin;

use App\Models\Helpers\Base;
use Illuminate\Support\Facades\Lang;

class Book extends Base
{
    const COVER_HARD = 'H'; // Hard
    const COVER_SOFT = 'S'; // Soft

    const LETTER_LATIN = 'L'; // Lotin
    const LETTER_KRILL = 'K'; // Krill

    protected $fillable = ['product_id', 'price', 'leftover', 'cover',
    'paper_size', 'letter', 'color_id', 'status', 'deleted', 'updated_by', 'created_by'];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function color()
    {
        return $this->hasOne(Color::class, 'id', 'color_id');
    }

    public function coverLabel()
    {
        return self::coverTypes()[$this->cover];
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
        return [
            self::COVER_SOFT => Lang::get('admin.cover_soft'),
            self::COVER_HARD => Lang::get('admin.cover_hard'),
        ];
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
