<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use ImageResize;

class Image extends Model
{
    const TYPE_PRODUCT = "product";
    const TYPE_AUTHOR = "author";
    const TYPE_CATEGORY = "category";

    const UPLOAD_PATH = "uploads/";
    const THUMBNAIL_PATH = "/thumbnails";

    protected $fillable = [
        'name', 'type', 'orginal_name', 'size', 'extention'
    ];

    public function deleteImage()
    {
        if (File::exists($this->getImagePath()))
            File::delete($this->getImagePath());
    }
    
    public static function getPublicFolder($type)
    {
        return public_path(self::UPLOAD_PATH . $type);
    }

    public function getImagePath()
    {
        return self::getPublicFolder($this->type) . "/" . $this->name;
    }

    public function getOrginalImage()
    {
        return "/" . self::UPLOAD_PATH . $this->type
            . "/" . $this->name;
    }

    public function getImageUrl($size = "300x300")
    {
        return self::THUMBNAIL_PATH . "/" . $this->type 
            . "/" . $size . "/" . $this->name;
    }

    public function resizeImage($width = 300, $hight = 300)
    {
        // create thumbnails folder if not exists
        $path = public_path(self::THUMBNAIL_PATH);
        $this->mkdirFolder($path);
        
        // create type folder if not exists
        $path .= "/" . $this->type;
        $this->mkdirFolder($path);

        // create size folder if not exists
        $path .= "/" . $width . "x" . $hight;
        $this->mkdirFolder($path);

        $img = ImageResize::make($this->getImagePath());
        $img->resize($width, $hight, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path .'/'. $this->name);
    }

    public function mkdirFolder($path)
    {
        // create folder if not exists
        if (!File::exists($path))
            File::makeDirectory($path, $mode = 0777, true, true);
    }
}
