<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATE_NEW = "N";
    const STATE_PAYED = "P";

    const TYPE_PRODUCT = "P";
    const TYPE_EBOOK = "E";

    protected $fillable = [
        'customer_id', 'total', 'subtotal', 'discount', 'state', 'type', 'updated_by'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function stateLabel()
    {
        return $this->getState()[$this->state];
    }

    public function stateHTML()
    {
        $title = $this->getState()[$this->state];

        switch($this->state) {
            case self::STATE_NEW:
                return "<span class='badge badge-primary'>{$title}</span>";
            case self::STATE_PAYED:
                return "<span class='badge badge-success'>{$title}</span>";
        }

        return "None";
    }

    public static function getState()
    {
        return [
            self::STATE_NEW => "Новый",
            self::STATE_PAYED => "Оплачено",
        ];
    }
}
