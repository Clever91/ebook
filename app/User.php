<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    const ROLE_ADMIN = 1; // admin role
    const ROLE_MANAGER = 2; // manager role
    const ROLE_MODERATOR = 3; // moderator role
    const ROLE_CLIENT = 4; // client role

    const STATUS_NO_ACTIVE = 0; // not active
    const STATUS_ACTIVE = 1; // active

    const ADMIN = 1;
    const NO_ADMIN = 0;

    const DELETED_ACTIVE = 1;
    const DELETED_NO_ACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password', 'is_admin', 'role', 'active', 'is_deleted'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'validation.required' => __('error.field_required'),
        ];
    }

    public function makePassword()
    {
        $this->password  = Hash::make($this->password);
    }

    public function roles()
    {
        return [
            self::ROLE_MODERATOR => "Модератор",
            self::ROLE_MANAGER => "Менеджер",
            self::ROLE_ADMIN => "Администратор",
        ];
    }

    public function roleLabel()
    {
        return $this->roles()[$this->role];
    }

    public function isSuperAdmin()
    {
        return $this->is_admin == self::ADMIN;
    }

    public function isAdmin()
    {
        return $this->role == self::ROLE_ADMIN;
    }

    public function isActive()
    {
        return $this->active == self::STATUS_ACTIVE;
    }

    public function makeDeleted()
    {
        $this->is_deleted = self::DELETED_ACTIVE;
        $this->save();
    }
}
