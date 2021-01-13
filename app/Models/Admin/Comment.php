<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_NO_ACTIVE = 0;

    protected $fillable = [
        'customer_id', 'commentable_id', 'commentable_type', 'body', 'status', 'parent_id', 'updated_by'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->where('status', self::STATUS_ACTIVE);
    }

    public function types()
    {
        return [
            'P', 'C', 'A'
        ];
    }
}
