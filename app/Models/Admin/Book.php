<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class Book extends Model
{
    const COVER_HARD = 'H'; // Hard
    const COVER_SOFT = 'S'; // Soft

    const LETTER_LATIN = 'L'; // Lotin
    const LETTER_KRILL = 'K'; // Krill

    const COLOR_WHITE = 'Wh'; // White
    const COLOR_BLACK = 'Bl'; // Black
    const COLOR_GREEN = 'Gr'; // Green

    protected $fillable = ['product_id', 'price', 'leftover', 'cover',
    'paper_size', 'letter', 'color', 'status', 'updated_by', 'created_by'];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
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

    public static function paperSizeTypes()
    {
        return [
            'A4', 'A5', 'A6'
        ];
    }

    public static function colorTypes()
    {
        return [
            self::COLOR_WHITE => Lang::get('admin.color_white'),
            self::COLOR_BLACK => Lang::get('admin.color_black'),
            self::COLOR_GREEN => Lang::get('admin.color_green'),
        ];
    }
}
