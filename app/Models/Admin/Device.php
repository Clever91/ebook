<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Device extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_NO_ACTIVE = 0;

    protected $fillable = [
        'name', 'model', 'os_version', 'app_version', 'type', 'status', 'uuid', 'token', 'api_token'
    ];

    public function makeNotActive()
    {
        $this->status = self::STATUS_NO_ACTIVE;
        $this->save();
    }

    public function updateApiToken()
    {
        $this->api_token = Str::random(80);
        $this->save();
    }

    public function getApiToken()
    {
        return $this->api_token;
    }
}
