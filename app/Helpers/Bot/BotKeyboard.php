<?php

namespace App\Helpers\Bot;

use Telegram\Bot\Keyboard\Keyboard;

class BotKeyboard {

    public static function product($product_id, $number = 1)
    {
        $btnProduct = Keyboard::button([
            'text' => 'Сделать заказ',
            'callback_data' => '{"pro":'.$product_id.'}'
        ]);

        $btnMinus = Keyboard::button([
            'text' => '➖',
            'callback_data' => '{"btn":"sub","num":'.$number.',"pro":'.$product_id.'}'
        ]);

        $btnPlus = Keyboard::button([
            'text' => '➕',
            'callback_data' => '{"btn":"add","num":'.$number.',"pro":'.$product_id.'}'
        ]);

        $btnNumber = Keyboard::button([
            'text' => $number,
            'callback_data' => '{"num":"'.$number.'"}'
        ]);

        $reply_markup = Keyboard::make([
            'inline_keyboard' => [
                [ $btnMinus, $btnNumber, $btnPlus ],
                [ $btnProduct ]
            ],
        ]);

        return $reply_markup;
    }
}

?>