<?php

namespace App\Models\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

abstract class Base extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_NO_ACTIVE = 0;

    const DEFAULT = 1;
    const NO_DEFAULT = 0;

    const DELETED = 1;
    const NO_DELETED = 0;

    const NO_IMAGE = "/images/no_image.jpg";

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function activeLabel()
    {
        return $this->getActive()[$this->status];
    }

    public function getActive()
    {
        return [
            self::STATUS_ACTIVE => "Активно",
            self::STATUS_NO_ACTIVE => "Не активно"
        ];
    }

    public function isDefault()
    {
        return $this->is_default == self::DEFAULT;
    }

    public function makeDeleted()
    {
        $this->deleted = self::DELETED;
        $this->save();
    }

    public function isDeleted()
    {
        return $this->deleted ==self::DELETED;
    }

    public static function activeOn($status)
    {
        return $status == "on" ? self::STATUS_ACTIVE : self::STATUS_NO_ACTIVE;
    }

    public static function isDefaultOn($default)
    {
        return $default == "on" ? self::DEFAULT : self::NO_DEFAULT;
    }

    public function generateFilename($extention = "epub")
    {
        return $this->id."_".time().'.'.$extention;
    }

    public function hasImage()
    {
        return !is_null($this->image);
    }

    public function getImage($width = 300, $hight = 300)
    {
        $size = $width . "x" . $hight;
        if ($this->image) {
            $url = $this->image->getImageUrl($size);
            if (File::exists($url))
                return $url;
            $this->image->resizeImage($width, $hight);
            return $this->image->getImageUrl($size);
        }

        return self::NO_IMAGE;
    }
}
