<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Files extends Model
{
    protected $fillable = [
        'name', 'orginal_name', 'size', 'extention'
    ];

    public function deleteFile()
    {
        if (File::exists($this->getFilePath()))
            File::delete($this->getFilePath());
    }

    public static function getPublicFolder()
    {
        return public_path('uploads/ebooks/');
    }

    public function getFilePath()
    {
        return self::getPublicFolder().$this->name;
    }
}
