<?php

namespace App\Helpers\Bot;

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
            'callback_data' => '{"pro":'.$product_id.',"num":'.$number.',"del":"1"}'
        ]);

        $pochta = Keyboard::button([
            'text' => 'Почта',
            'callback_data' => '{"pro":'.$product_id.',"num":'.$number.',"del":"2"}'
        ]);

        $pickup = Keyboard::button([
            'text' => 'Самовывоз',
            'callback_data' => '{"pro":'.$product_id.',"num":'.$number.',"del":"3"}'
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
}

?>