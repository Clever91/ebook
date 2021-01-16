<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    const COVER_HARD = 'H'; // Hard
    const COVER_SOFT = 'S'; // Soft

    const LETTER_LATIN = 'L'; // Lotin
    const LETTER_KRILL = 'K'; // Krill

    const COLOR_WHITE = 'Wh'; // White
    const COLOR_BLACK = 'Bl'; // BL

    protected $fillable = ['product_id', 'price', 'leftover', 'cover',
    'paper_size', 'letter', 'color', 'status', 'updated_by', 'created_by'];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
