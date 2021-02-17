<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATE_DRAF = "D"; // draf
    const STATE_NEW = "N"; // new
    const STATE_ARCHIVE = "A"; // archive
    const STATE_CANCEL = "C"; // cancel
    const STATE_RETRUN = "R"; // return

    const TYPE_BOOK = "B"; // book
    const TYPE_EBOOK = "E"; // ebook
    const TYPE_AUDIO = "A"; // audio
    const TYPE_GOOD = "G"; // good

    protected $fillable = [
        'customer_id', 'total', 'subtotal', 'discount', 'state',
        'order_type', 'chat_order_id', 'updated_by'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function ebooks()
    {
        return $this->hasMany(OrderEbook::class);
    }

    public function stateLabel()
    {
        return $this->getState()[$this->state];
    }

    public function stateHTML()
    {
        $title = $this->getState()[$this->state];

        switch($this->state) {
            case self::STATE_DRAF:
                return "<span class='badge badge-danger'>{$title}</span>";
            case self::STATE_NEW:
                return "<span class='badge badge-primary'>{$title}</span>";
        }

        return "None";
    }

    public static function getState()
    {
        return [
            self::STATE_NEW => "Новый",
            // self::STATE_DRAF => "Оплачено",
        ];
    }
}
