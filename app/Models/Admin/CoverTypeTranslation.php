<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class CoverTypeTranslation extends Model
{
    protected $fillable = [
        'cover_type_id', 'locale', 'is_default', 'name'
    ];

    public function coverType()
    {
        return $this->belongsTo(CoverType::class);
    }
}
