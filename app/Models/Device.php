<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_NO_ACTIVE = 0;

    protected $fillable = [
        'name', 'model', 'os_version', 'app_version', 'type', 'status', 'uuid', 'token'
    ];

    public function makeNotActive()
    {
        $this->status = self::STATUS_NO_ACTIVE;
        $this->save();
    }
}
