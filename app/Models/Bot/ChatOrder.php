<?php

namespace App\Models\Bot;

use App\Helpers\Common\GlobalFunc;
use App\Models\Admin\Order;
use App\Models\Admin\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

class ChatOrder extends Model
{
    // const DELIVERY_MAIL = 1;
    // const DELIVERY_EXPRESS24 = 2;
    const DELIVERY_PICKUP = 3;
    const DELIVERY_DELIVERY = 4;

    const PAYMENT_PAYME = 1;
    const PAYMENT_CLICK = 2;
    const PAYMENT_CASH = 3;

    const STATE_DRAF = "D"; // Draf
    const STATE_NEW = "N"; // New
    const STATE_COMPLATE = "C"; // Complated

    const PAID_NOT = 0;
    const PAID_SUCCESS = 1;

    protected $fillable = [
        "chat_id", "delivery_type", "payment_type", "delivery_price",
        "amount", "state", "status", "paid", "phone", "code", "updated_by",
        "lat", "long", "message_id"
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

    public function isPickUp()
    {
        return $this->delivery_type == self::DELIVERY_PICKUP;
    }

    public function deliveryLabel()
    {
        if (empty($this->delivery_type))
            return "Нет";
        return $this->deliveryTypes()[$this->delivery_type];
    }

    public function deliveryTypes()
    {
        return [
            // self::DELIVERY_EXPRESS24 => 'Express24',
            // self::DELIVERY_MAIL => Lang::get('bot.delivery_mail'),
            self::DELIVERY_DELIVERY => Lang::get('bot.delivery_text'),
            self::DELIVERY_PICKUP => Lang::get('bot.delivery_pickup'),
        ];
    }

    public function paymentLabel()
    {
        if (empty($this->payment_type))
            return "Нет";
        return $this->paymentTypes()[$this->payment_type];
    }

    public function paymentTypes()
    {
        return [
            self::PAYMENT_CASH => Lang::get('bot.payment_cash'),
            self::PAYMENT_CLICK => 'Click',
            self::PAYMENT_PAYME => 'Payme',
        ];
    }

    public function stateHtml()
    {
        $label = $this->states()[$this->state];
        switch($this->state) {
            case self::STATE_NEW:
                return '<span class="badge bg-primary">'.$label.'</span>';
            case self::STATE_DRAF:
                return '<span class="badge bg-danger">'.$label.'</span>';
            case self::STATE_COMPLATE:
                return '<span class="badge bg-success">'.$label.'</span>';
        }
        return "Нет";
    }

    public function states()
    {
        return [
            self::STATE_DRAF => "Черновой",
            self::STATE_NEW => "Новый",
            self::STATE_COMPLATE => "Завершено",
        ];
    }

    public function isPaidHtml()
    {
        if ($this->paid == self::PAID_SUCCESS)
            return '<span class="badge bg-success">Да</span>';
        return '<span class="badge bg-danger">Нет</span>';
    }

    public function isPaid()
    {
        return $this->paid == self::PAID_SUCCESS;
    }

    public function getLatLng()
    {
        return $this->lat . ", " . $this->long;
    }

    public function amountWithDelivery()
    {
        return $this->amount + $this->delivery_price;
    }

    public function telegramOrderList()
    {
        $text = Lang::get("bot.new_order") . "<b>" . $this->id . "</b> \n\n";
        $text .= Lang::get("bot.client_phone") . "<b>" . $this->phone . "</b>\n";
        $text .= Lang::get("bot.delivery_type") . "<b>" . $this->deliveryLabel() . "</b>\n";
        $text .= Lang::get("bot.payment_type") . "<b>". $this->paymentLabel() . "</b>\n";
        $text .= Lang::get("bot.location") . "<b>". $this->getLatLng() . "</b>\n\n";

        foreach($this->details as $index => $detail) {
            // $amount = $detail->price * $detail->quantity;
            $text .= ($index+1) .". ". $detail->product->name;
            if (!is_null($detail->book))
                $text .= " (" .$detail->book->getBtnLabel() .")\n";
            $text .= "✏️   ".$detail->quantity." x <i>" . GlobalFunc::moneyFormat($detail->price) ."</i>\n";
        }

        $text .= "\n";
        $text .= Lang::get("bot.amount")." <i>" . GlobalFunc::moneyFormat($this->amount) . "</i>\n";
        $text .= Lang::get("bot.delivery") ." <i>" . GlobalFunc::moneyFormat($this->delivery_price) . "</i>\n";
        $text .= Lang::get("bot.total") . " <i>" . GlobalFunc::moneyFormat($this->amountWithDelivery()) ."</i>\n\n";

        $text .= Lang::get("bot.order_paid") . " " . ($this->isPaid() ? "✅" : "⛔️");

        return $text;
    }

    public function createOrder($chatUser)
    {
        if (is_null($chatUser))
            return;
        $customer = $chatUser->customer();
        if (is_null($customer))
            return;
        // create order
        $order = new Order();
        $order->customer_id = $customer->id;
        $order->state = Order::STATE_DRAF;
        $order->order_type = Order::TYPE_BOOK;
        if ($order->save()) {
            // create order item
            foreach($this->details as $detail) {
                $amount = $detail->quantity * $detail->price;
                $item = new OrderItem();
                $item->order_id = $order->id;
                $item->item_id = $detail->book_id;
                $item->price = $detail->price;
                $item->quantity = $detail->quantity;
                $item->total_price = $amount;
                $item->item_type = Order::TYPE_BOOK;;
                if ($item->save()) {
                    $order->total += $amount;
                    $order->subtotal += $amount;
                }
            }
            $order->state = Order::STATE_NEW;
            $order->chat_order_id = $this->id;
            $order->save();
        }
        return true;
    }

    public function chatUser()
    {
        return ChatUser::where('chat_id', $this->chat_id)->first();
    }

}
