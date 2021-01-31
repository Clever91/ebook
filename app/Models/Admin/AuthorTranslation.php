<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AuthorTranslation extends Model
{
    protected $fillable = [
        'author_id', 'locale', 'is_default', 'name', 'bio'
    ];
}
