<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use ImageResize;

class Image extends Model
{
    const TYPE_PRODUCT = "product";
    const TYPE_CATEGORY = "category";

    protected $fillable = [
        'name', 'type', 'orginal_name', 'size', 'extention'
    ];

    public function deleteImage()
    {
        if (File::exists($this->getImagePath()))
            File::delete($this->getImagePath());
    }
    
    public static function getPublicFolder()
    {
        return public_path('uploads/products/');
    }

    public function getImagePath()
    {
        return self::getPublicFolder() . $this->name;
    }

    public function resizeImage($size = "300x300", $type = "product")
    {
        // create thumbnails folder if not exists
        $path = public_path('/thumbnails');
        $this->mkdirFolder($path);
        
        // create products folder if not exists
        $path .= "/" . $type;
        $this->mkdirFolder($path);

        // create size folder if not exists
        $path .= "/" . $size;
        $this->mkdirFolder($path);

        $img = ImageResize::make($this->getImagePath());
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path .'/'. $this->name);
    }

    private function mkdirFolder($path)
    {
        // create folder if not exists
        if (!File::exists($path))
            File::makeDirectory($path, $mode = 0777, true, true);
    }
}
