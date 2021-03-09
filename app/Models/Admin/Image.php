<?php

namespace App\Models\Admin;

use App\Models\Helpers\Base;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use ImageResize as ImageResize;

class Image extends Model
{
    const TYPE_PRODUCT = "product";
    const TYPE_BOOK = "book";
    const TYPE_AUTHOR = "author";
    const TYPE_CATEGORY = "category";
    const TYPE_GROUP = "group";

    const UPLOAD_PATH = "uploads/";
    const THUMBNAIL_PATH = "/thumbnails";

    protected $fillable = [
        'name', 'type', 'orginal_name', 'size', 'extension'
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
        $path = self::THUMBNAIL_PATH . "/" . $this->type
            . "/" . $size . "/" . $this->name;
        $public_path = public_path($path);
        if (!File::exists($public_path)) {
            $str = explode("x", $size);
            $width = $str[0];
            $hight = $str[1];
            $this->resizeImage($width, $hight);
        }
        return $path;
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

        $real_path = $this->getImagePath();
        if (!File::exists($real_path) || !File::isReadable($real_path))
            $real_path = public_path(Base::NO_IMAGE);

        $img = ImageResize::make($real_path);
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
