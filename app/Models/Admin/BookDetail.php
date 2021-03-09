<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class BookDetail extends Model
{
    protected $fillable = [
        'page_count', 'weight', 'isbn', 'bar_code',
        'publisher', 'year', 'updated_by', 'created_by'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
