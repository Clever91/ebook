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
        'customer_id', 'price_type_id', 'total', 'subtotal', 'discount', 'state',
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
            self::STATE_DRAF => "Draf",
            self::STATE_NEW => "Новый",
            self::STATE_ARCHIVE => "Archive",
            self::STATE_CANCEL => "Cancel",
            self::STATE_RETRUN => "Return",
        ];
    }

    public function createPayment($data)
    {
        $payment = OrderPayment::create([
            'order_id' => $this->id,
            'amount' => $data['amount'],
            'type' => $data['type'], // payme, click, cash, bm24
            'currency' => isset($data['currency']) ? $data['currency'] : 'UZS',
            'paid' => isset($data['paid']) ? $data['paid'] : false,
            'json_data' => isset($data['json']) ? $data['json'] : null,
        ]);
        return $payment;
    }
}
