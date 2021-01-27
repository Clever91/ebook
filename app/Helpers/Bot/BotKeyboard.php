<?php

namespace App\Helpers\Bot;

use App\Helpers\Common\ClickHelper;
use App\Helpers\Common\PaymeHelper;
use App\Models\Admin\Setting;
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
            'text' => Lang::get('bot.add_to_cart'),
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

        $home = Keyboard::button([
            'text' => Lang::get('bot.btn_home'),
            'callback_data' => '{"home":"1"}'
        ]);

        $show = Keyboard::button([
            'text' => $number,
            'callback_data' => '{"num":"'.$number.'"}'
        ]);

        $reply_markup = Keyboard::make([
            'inline_keyboard' => [
                [ $minus, $show, $plus ],
                [ $add ],
                [ $home ],
            ],
        ]);

        return $reply_markup;
    }

    public static function categories($categories)
    {
        $keyboard = [];
        foreach($categories as $category) {
            if ($category->products->count()) {
                $btn = Keyboard::button([
                    'text' => $category->name,
                    'callback_data' => '{"cat":'.$category->id.'}'
                ]);
                $keyboard[] = [ $btn ];
            }
        }

        $cart = Keyboard::button([
            'text' => Lang::get('bot.btn_cart'),
            'callback_data' => '{"cart":"1"}'
        ]);
        $keyboard[] = [ $cart ];

        $reply_markup = Keyboard::make([
            'inline_keyboard' => $keyboard,
        ]);

        return $reply_markup;
    }

    public static function products($products, $back = 1)
    {
        // $item = [];
        $keyboard = [];
        foreach($products as $index => $product) {

            $btn = Keyboard::button([
                'text' => $product->name,
                'callback_data' => '{"pro":'.$product->id.'}'
            ]);
            // $item[] = $btn;

            // if ($index % 2 != 0) {
            //     $keyboard[] = $item;
            //     $item = [];
            // }
            $keyboard[] = [ $btn ];
        }

        // back
        $back = Keyboard::button([
            'text' => Lang::get('bot.btn_back'),
            'callback_data' => '{"back":'.$back.'}'
        ]);
        $keyboard[] = [ $back ];

        // cart
        $cart = Keyboard::button([
            'text' => Lang::get('bot.btn_cart'),
            'callback_data' => '{"cart":"1"}'
        ]);
        $keyboard[] = [ $cart ];

        $reply_markup = Keyboard::make([
            'inline_keyboard' => $keyboard,
        ]);

        return $reply_markup;
    }

    public static function cart($details, $back = 2)
    {
        $keyboard = [];
        $makeOrder = Keyboard::button([
            'text' => Lang::get('bot.make_order'),
            'callback_data' => '{"order":"1"}'
        ]);
        $clear = Keyboard::button([
            'text' => Lang::get('bot.clear_cart'),
            'callback_data' => '{"clear":1}'
        ]);
        $keyboard[] = [ $clear, $makeOrder ];

        foreach($details as $detail) {
            $btn = Keyboard::button([
                'text' => $detail->product->name . " ❌",
                'callback_data' => '{"remove":'.$detail->id.'}'
            ]);
            $keyboard[] = [ $btn ];
        }

        $home = Keyboard::button([
            'text' => Lang::get('bot.btn_home'),
            'callback_data' => '{"home":"1"}'
        ]);
        $keyboard[] = [ $home ];

        $reply_markup = Keyboard::make([
            'inline_keyboard' => $keyboard,
        ]);

        return $reply_markup;
    }

    public static function delivery($back = 3)
    {
        $express24 = Keyboard::button([
            'text' => 'Express24',
            'callback_data' => '{"del":"'.ChatOrder::DELIVERY_EXPRESS24.'"}'
        ]);

        $pochta = Keyboard::button([
            'text' => Lang::get('bot.delivery_mail'),
            'callback_data' => '{"del":"'.ChatOrder::DELIVERY_MAIL.'"}'
        ]);

        $pickup = Keyboard::button([
            'text' => Lang::get('bot.delivery_pickup'),
            'callback_data' => '{"del":"'.ChatOrder::DELIVERY_PICKUP.'"}'
        ]);

        $back = Keyboard::button([
            'text' => '⬅️ '.Lang::get('bot.btn_back'),
            'callback_data' => '{"back":'.$back.'}'
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

        $cart = Keyboard::button([
            'text' => Lang::get('bot.btn_cart'),
        ]);

        $reply_markup = Keyboard::make([
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
            'keyboard' => [
                [ $contact ],
                [ $cart ],
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

    public static function totalCheck($amount, $order_id, $back = 7)
    {
        $click_url = ClickHelper::followingLink($amount, $order_id);
        $payme_url = PaymeHelper::followingLink($amount, $order_id);

        $keyboard = [];
        if (Setting::get("payme") == "on") {
            $payme = Keyboard::button([
                'text' => 'Payme',
                'url' => $payme_url
            ]);
            array_push($keyboard, [ $payme ]);
        }

        // $payme_telegram = Keyboard::button([
        //     'text' => 'Payme (с телеграммой)',
        //     'callback_data' => '{"pay":true,"type":"payme"}'
        // ]);

        if (Setting::get("click") == "on") {
            $click = Keyboard::button([
                'text' => 'Click',
                'url' => $click_url
            ]);
            array_push($keyboard, [ $click ]);
        }

        if (Setting::get("telegram") == "on") {
            $click_telegram = Keyboard::button([
                'text' => 'Telegram',
                'callback_data' => '{"pay":true,"type":"click"}'
            ]);
            array_push($keyboard, [ $click_telegram ]);
        }

        $cash = Keyboard::button([
            'text' => Lang::get('bot.payment_cash'),
            'callback_data' => '{"pay":true,"type":"cash"}'
        ]);
        array_push($keyboard, [ $cash ]);

        $backBtn = Keyboard::button([
            'text' => '⬅️ '.Lang::get('bot.btn_back'),
            'callback_data' => '{"back":'.$back.'}'
        ]);
        array_push($keyboard, [ $backBtn ]);

        $reply_markup = Keyboard::make([
            'inline_keyboard' => $keyboard,
        ]);

        return $reply_markup;
    }

    public static function home()
    {
        $keyboard = [
            [
                Keyboard::button([
                    'text' => Lang::get('bot.btn_home'),
                    'callback_data' => '{"home":"1"}'
                ])
            ]
         ];

        $reply_markup = Keyboard::make([
            'inline_keyboard' => $keyboard,
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
