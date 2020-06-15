<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class Base extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_NO_ACTIVE = 0;

    const DEFAULT = 1;
    const NO_DEFAULT = 0;

    const DELETED = 1;
    const NO_DELETED = 0;

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

    public static function activeOn($status)
    {
        return $status == "on" ? self::STATUS_ACTIVE : self::STATUS_NO_ACTIVE;
    }

    public static function isDefaultOn($default)
    {
        return $default == "on" ? self::DEFAULT : self::NO_DEFAULT;
    }
}
