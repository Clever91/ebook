<?php

namespace App\Models\Bot;

use Illuminate\Database\Eloquent\Model;

class ChatOrder extends Model
{
    const DELIVERY_MAIL = 1;
    const DELIVERY_EXPRESS24 = 2;
    const DELIVERY_PICKUP = 3;

    const PAYMENT_PAYME = 1;
    const PAYMENT_CLICK = 2;
    const PAYMENT_CASH = 3;

    const STATE_DRAF = 0;
    const STATE_NEW = 1;
    const STATE_COMPLATE = 5;

    protected $fillable = [
        "chat_id", "delivery_type", "payment_type", "delivery_price",
        "amount", "state", "status", "paid", "phone", "code", "updated_by",
        "lat", "long"
    ];

    public function details()
    {
        return $this->hasMany(ChatOrderDetail::class);
    }

    public function deleteDetails()
    {
        if (empty($this->details))
            return true;

        foreach($this->details as $detail) {
            $detail->delete();
        }

        return true;
    }

}
