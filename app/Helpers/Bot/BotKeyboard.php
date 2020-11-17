<?php

namespace App\Helpers\Bot;

use App\Models\Bot\ChatOrder;
use Telegram\Bot\Keyboard\Keyboard;

class BotKeyboard {

    public static function alert($callback, $msg, $type = false)
    {
        return [
            'callback_query_id' => $callback->getId(),
            'text' => $msg,
            'show_alert' => $type,
        ];
    }

    public static function product($product_id, $number = 1)
    {
        $add = Keyboard::button([
            'text' => 'Сделать заказ',
            'callback_data' => '{"add":"1","pro":'.$product_id.',"num":'.$number.'}'
        ]);

        $minus = Keyboard::button([
            'text' => '➖',
            'callback_data' => '{"btn":"sub","num":'.$number.',"pro":'.$product_id.'}'
        ]);

        $plus = Keyboard::button([
            'text' => '➕',
            'callback_data' => '{"btn":"add","num":'.$number.',"pro":'.$product_id.'}'
        ]);

        $show = Keyboard::button([
            'text' => $number,
            'callback_data' => '{"num":"'.$number.'"}'
        ]);

        $reply_markup = Keyboard::make([
            'inline_keyboard' => [
                [ $minus, $show, $plus ],
                [ $add ]
            ],
        ]);

        return $reply_markup;
    }

    public static function delivery($product_id, $number = 1)
    {
        $express24 = Keyboard::button([
            'text' => 'Express24',
            'callback_data' => '{"pro":'.$product_id.',"del":"'.ChatOrder::DELIVERY_EXPRESS24.'"}'
        ]);

        $pochta = Keyboard::button([
            'text' => 'Почта',
            'callback_data' => '{"pro":'.$product_id.',"del":"'.ChatOrder::DELIVERY_MAIL.'"}'
        ]);

        $pickup = Keyboard::button([
            'text' => 'Самовывоз',
            'callback_data' => '{"pro":'.$product_id.',"del":"'.ChatOrder::DELIVERY_PICKUP.'"}'
        ]);

        $back = Keyboard::button([
            'text' => '⬅️ Назад',
            'callback_data' => '{"pro":'.$product_id.',"num":'.$number.',"back":"1"}'
        ]);

        $reply_markup = Keyboard::make([
            'inline_keyboard' => [
                [ $express24 ],
                [ $pochta ],
                [ $pickup ],
                [ $back ]
            ],
        ]);

        return $reply_markup;
    }

    public static function contact()
    {
        $contact = Keyboard::button([
            'text' => '📞 Отправьте свой номер телефона',
            'request_contact' => true
        ]);

        $reply_markup = Keyboard::make([
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
            'keyboard' => [
                [ $contact ]
            ],
        ]);

        return $reply_markup;
    }

    public static function location()
    {
        $location = Keyboard::button([
            'text' => '📍 Отправьте свое местоположение',
            'request_location' => true
        ]);

        $reply_markup = Keyboard::make([
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
            'keyboard' => [
                [ $location ]
            ],
        ]);

        return $reply_markup;
    }

    public static function check_code()
    {
        $location = Keyboard::button([
            'text' => '⏱ Я не получил код, пожалуйста, пришлите код еще раз'
        ]);

        $reply_markup = Keyboard::make([
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
            'keyboard' => [
                [ $location ]
            ],
        ]);

        return $reply_markup;
    }

    public static function totalCheck()
    {
        $payme = Keyboard::button([
            'text' => 'Payme',
            'callback_data' => '{"pay":true,"type":"payme"}'
        ]);

        $click = Keyboard::button([
            'text' => 'Click',
            'callback_data' => '{"pay":true,"type":"click"}'
        ]);

        $cash = Keyboard::button([
            'text' => 'Наличные',
            'callback_data' => '{"pay":true,"type":"cash"}'
        ]);

        $reply_markup = Keyboard::make([
            'inline_keyboard' => [
                [ $payme ],
                [ $click ],
                [ $cash ],
            ],
        ]);

        return $reply_markup;
    }

    public static function hideKeyboard()
    {
        $reply_markup = Keyboard::make([
            'remove_keyboard' => true
        ]);

        return $reply_markup;
    }
}

?>