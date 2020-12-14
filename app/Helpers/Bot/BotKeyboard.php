<?php

namespace App\Helpers\Bot;

use App\Helpers\Common\ClickHelper;
use App\Models\Bot\ChatOrder;
use Illuminate\Support\Facades\Lang;
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
            'text' => Lang::get('bot.make_order'),
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
            'text' => Lang::get('bot.delivery_mail'),
            'callback_data' => '{"pro":'.$product_id.',"del":"'.ChatOrder::DELIVERY_MAIL.'"}'
        ]);

        $pickup = Keyboard::button([
            'text' => Lang::get('bot.delivery_pickup'),
            'callback_data' => '{"pro":'.$product_id.',"del":"'.ChatOrder::DELIVERY_PICKUP.'"}'
        ]);

        $back = Keyboard::button([
            'text' => '⬅️ '.Lang::get('bot.btn_back'),
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
            'text' => Lang::get('bot.send_your_phone_number'),
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
            'text' => Lang::get('bot.send_your_location'),
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
            'text' => Lang::get('bot.not_revieced_code')
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

    public static function totalCheck($amount = 0)
    {
        $click_url = ClickHelper::followingLink($amount);
        $payme_url = ClickHelper::followingLink($amount);

        $payme_app = Keyboard::button([
            'text' => 'Payme (с приложением)',
            'url' => $payme_url
        ]);

        $payme_telegram = Keyboard::button([
            'text' => 'Payme (с телеграммой)',
            'callback_data' => '{"pay":true,"type":"payme"}'
        ]);

        $click_app = Keyboard::button([
            'text' => 'Click (с приложением)',
            'url' => $click_url
        ]);

        $click_telegram = Keyboard::button([
            'text' => 'Click (с телеграммой)',
            'callback_data' => '{"pay":true,"type":"click"}'
        ]);

        $cash = Keyboard::button([
            'text' => Lang::get('bot.payment_cash'),
            'callback_data' => '{"pay":true,"type":"cash"}'
        ]);

        $reply_markup = Keyboard::make([
            'inline_keyboard' => [
                [ $payme_app ],
                [ $payme_telegram ],
                [ $click_app ],
                [ $click_telegram ],
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