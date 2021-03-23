<?php

namespace App\Helpers\Bot;

use App\Helpers\Common\ClickHelper;
use App\Helpers\Common\GlobalFunc;
use App\Helpers\Common\PaymeHelper;
use App\Helpers\Log\TelegramLog;
use App\Models\Admin\Book;
use App\Models\Admin\Color;
use App\Models\Admin\CoverType;
use App\Models\Admin\Product;
use App\Models\Admin\Setting;
use App\Models\Bot\ChatOrder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Lunaweb\Localization\Facades\Localization;
use Telegram\Bot\Keyboard\Keyboard;

class BotKeyboard {

    public static function welcome()
    {
        $keyboard = [];
        $langs = Localization::getLocales();

        foreach($langs as $code => $lang) {
            $btn = Keyboard::button([
                'text' => $lang['emoji'] ." ". $lang['name'],
                'callback_data' => '{"lang":"'.$code.'"}'
            ]);
            array_push($keyboard, [ $btn ]);
        }

        $reply_markup = Keyboard::make([
            'inline_keyboard' => $keyboard,
        ]);

        return $reply_markup;
    }

    public static function main()
    {
        $keyboard = [];
        $btn = Keyboard::button([
            'text' => "🏠 Main "
        ]);
        array_push($keyboard, [ $btn ]);

        $reply_markup = Keyboard::make([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => false,
            'selective' => true
        ]);

        return $reply_markup;
    }

    public static function changeLang($locale = "ru")
    {
        $keyboard = [];
        $langs = Localization::getLocales();

        foreach($langs as $code => $lang) {
            $txt = $lang['emoji'] ." ". $lang['name'];
            if ($code == $locale)
                $txt = "✔️ " . $txt;
            $btn = Keyboard::button([
                'text' => $txt,
                'callback_data' => '{"lang":"'.$code.'"}'
            ]);
            array_push($keyboard, [ $btn ]);
        }

        // back
        $back = Keyboard::button([
            'text' => Lang::get('bot.btn_back'),
            'callback_data' => '{"back":0}'
        ]);
        $keyboard[] = [ $back ];

        $reply_markup = Keyboard::make([
            'inline_keyboard' => $keyboard,
        ]);

        return $reply_markup;
    }

    public static function settings()
    {
        $keyboard = [];

        // language
        $langs = Keyboard::button([
            'text' => Lang::get('bot.btn_languages'),
            'callback_data' => '{"langs":1}'
        ]);
        array_push($keyboard, [ $langs ]);

        // customer phone
        $phone = Keyboard::button([
            'text' => Lang::get('bot.btn_customer_phone'),
            'callback_data' => '{"phone":1}'
        ]);
        array_push($keyboard, [ $phone ]);

        // back
        $back = Keyboard::button([
            'text' => Lang::get('bot.btn_back'),
            'callback_data' => '{"back":0}'
        ]);
        $keyboard[] = [ $back ];

        $reply_markup = Keyboard::make([
            'inline_keyboard' => $keyboard,
        ]);

        return $reply_markup;
    }

    public static function alert($callback, $msg, $type = false)
    {
        return [
            'callback_query_id' => $callback->getId(),
            'text' => $msg,
            'show_alert' => $type,
        ];
    }

    public static function product($product_id, $number = 1, $locale = 'ru', $book = null, $back = 4)
    {
        $keyboard = [];
        $product = Product::find($product_id);
        $selected = $book;
        if (is_null($selected) && !is_null($product))
            $selected = $product->book();
        // get books by price
        if (!is_null($product)) {
            $books = Book::where([
                'product_id' => $product->id,
                'status' => Product::STATUS_ACTIVE,
                'deleted' => Product::NO_DELETED,
            ])->orderBy('price', 'asc')->get();
            if ($books->count() > 1) {
                foreach($books as $b) {
                    $txt = $b->getBtnLabel($locale);
                    if ($b->id == $selected->id)
                        $txt = "✔️ ".$txt;
                    $btn = Keyboard::button([
                        'text' => $txt,
                        'callback_data' => '{"b_id":'.$b->id.',"num":'.$number.',"pro":'.$product_id.',"ch":1}'
                    ]);
                    array_push($keyboard, [ $btn ]);
                }
            }
        }
        // default buttons
        $minus = Keyboard::button([
            'text' => '➖',
            'callback_data' => '{"b_id":'.$selected->id.',"btn":"sub","num":'.$number.',"pro":'.$product_id.'}'
        ]);
        // show number
        $show = Keyboard::button([
            'text' => $number,
            'callback_data' => '{"num":"'.$number.'"}'
        ]);
        // plus
        $plus = Keyboard::button([
            'text' => '➕',
            'callback_data' => '{"b_id":'.$selected->id.',"btn":"add","num":'.$number.',"pro":'.$product_id.'}'
        ]);
        array_push($keyboard, [ $minus, $show, $plus ]);
        // add to cart
        $add = Keyboard::button([
            'text' => Lang::get('bot.add_to_cart'),
            'callback_data' => '{"add":"1","pro":'.$product_id.',"num":'.$number.',"b_id":'.$selected->id.'}'
        ]);
        array_push($keyboard, [ $add ]);
        // back btn
        $btnBack = Keyboard::button([
            'text' => Lang::get('bot.btn_back'),
            'callback_data' => '{"back":'.$back.',"cat":'.$product->category_id.'}'
        ]);
        array_push($keyboard, [ $btnBack ]);
        // home
        $home = Keyboard::button([
            'text' => Lang::get('bot.btn_home'),
            'callback_data' => '{"home":"1"}'
        ]);
        array_push($keyboard, [ $home ]);
        // reply markup
        $reply_markup = Keyboard::make([
            'inline_keyboard' => $keyboard,
        ]);

        return $reply_markup;
    }

    public static function categories($categories)
    {
        $keyboard = [];
        foreach($categories as $category) {
            if ($category->products->count()) {
                $btn = Keyboard::button([
                    'text' => $category->translateorNew(App::getLocale())->name,
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

        $setting = Keyboard::button([
            'text' => Lang::get('bot.btn_setting'),
            'callback_data' => '{"setting":"1"}'
        ]);
        $keyboard[] = [ $setting ];

        $reply_markup = Keyboard::make([
            'inline_keyboard' => $keyboard,
        ]);

        return $reply_markup;
    }

    public static function products($products, $back = 1)
    {
        // $item = [];
        $keyboard = [];
        foreach($products as $product) {

            $btn = Keyboard::button([
                'text' => $product->translateorNew(App::getLocale())->name,
                'callback_data' => '{"pro":'.$product->id.'}'
            ]);
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

        $home = Keyboard::button([
            'text' => Lang::get('bot.btn_home'),
            'callback_data' => '{"home":"1"}'
        ]);
        $clear = Keyboard::button([
            'text' => Lang::get('bot.clear_cart'),
            'callback_data' => '{"clear":1}'
        ]);
        $keyboard[] = [ $clear, $home ];

        foreach($details as $detail) {
            $btn = Keyboard::button([
                'text' => "❌ ".$detail->product->translateorNew(App::getLocale())->name,
                'callback_data' => '{"remove":'.$detail->id.'}'
            ]);
            $keyboard[] = [ $btn ];
        }

        $makeOrder = Keyboard::button([
            'text' => Lang::get('bot.make_order'),
            'callback_data' => '{"order":"1"}'
        ]);
        $keyboard[] = [ $makeOrder ];

        $reply_markup = Keyboard::make([
            'inline_keyboard' => $keyboard,
        ]);

        return $reply_markup;
    }

    public static function delivery($back = 3)
    {
        $delivery = Keyboard::button([
            'text' => Lang::get('bot.delivery_text'),
            'callback_data' => '{"del":"'.ChatOrder::DELIVERY_DELIVERY.'"}'
        ]);

        // $pochta = Keyboard::button([
        //     'text' => Lang::get('bot.delivery_mail'),
        //     'callback_data' => '{"del":"'.ChatOrder::DELIVERY_MAIL.'"}'
        // ]);

        // $pickup = Keyboard::button([
        //     'text' => Lang::get('bot.delivery_pickup'),
        //     'callback_data' => '{"del":"'.ChatOrder::DELIVERY_PICKUP.'"}'
        // ]);

        $back = Keyboard::button([
            'text' => Lang::get('bot.btn_back'),
            'callback_data' => '{"back":'.$back.'}'
        ]);

        $reply_markup = Keyboard::make([
            'inline_keyboard' => [
                [ $delivery ],
                // [ $pochta ],
                // [ $pickup ],
                [ $back ],
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

    public static function location($lastOrder = null)
    {
        $keyboard = [];
        if (!is_null($lastOrder)) {
            $last = Keyboard::button([
                'text' => Lang::get('bot.last_order_location')
            ]);
            array_push($keyboard, [ $last ]);
        }

        $location = Keyboard::button([
            'text' => Lang::get('bot.send_your_location'),
            'request_location' => true
        ]);
        array_push($keyboard, [ $location ]);

        $cart = Keyboard::button([
            'text' => Lang::get('bot.btn_cart'),
        ]);
        array_push($keyboard, [ $cart ]);

        $reply_markup = Keyboard::make([
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
            'keyboard' => $keyboard,
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

    public static function totalCheck($amount, $order, $back = 7)
    {
        $click_url = ClickHelper::followingLink($amount, $order->id);
        // $payme_url = PaymeHelper::followingLink($amount, $order->id);
        // $payme_url = PaymeHelper::bm24Link($amount);
        $showCash = GlobalFunc::showCashPayment($order->distance);

        $keyboard = [];

        $backBtn = Keyboard::button([
            'text' => Lang::get('bot.btn_back'),
            'callback_data' => '{"back":'.$back.'}'
        ]);
        array_push($keyboard, [ $backBtn ]);

        if (Setting::get("payme") == "on") {
            // $payme = Keyboard::button([
            //     'text' => 'Payme',
            //     'url' => $payme_url
            // ]);
            // array_push($keyboard, [ $payme ]);
            $bm24 = Keyboard::button([
                'text' => 'Payme',
                'callback_data' => '{"pay":true,"type":"bm24"}'
            ]);
            array_push($keyboard, [ $bm24 ]);
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

        if ($showCash == true) {
            $cash = Keyboard::button([
                'text' => Lang::get('bot.payment_cash'),
                'callback_data' => '{"pay":true,"type":"cash"}'
            ]);
            array_push($keyboard, [ $cash ]);
        }

        $cart = Keyboard::button([
            'text' => Lang::get('bot.btn_cart'),
            'callback_data' => '{"cart":"1"}'
        ]);
        array_push($keyboard, [ $cart ]);

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

    public static function status($order)
    {
        // if order is complated, so hide keyborad
        if ($order->state == ChatOrder::STATE_COMPLATE) {
            return false;
        }

        $keyboard = [];
        $labels = (new ChatOrder)->states();

        if (GlobalFunc::showPaid($order->payment_type) && $order->state != ChatOrder::STATE_CANCEL) {
            $noPaid = ($order->paid == ChatOrder::PAID_SUCCESS ? ChatOrder::PAID_NOT : ChatOrder::PAID_SUCCESS);
            $paid = Keyboard::button([
                'text' => "Оплачено " . ($noPaid == 0 ? '✅' : ''),
                'callback_data' => '{"paid":'.$noPaid.',"o":'.$order->id.'}'
            ]);
            array_push($keyboard, [ $paid ]);
        }

        if ($order->state == ChatOrder::STATE_NEW) {
            $btn = Keyboard::button([
                'text' => $labels[ChatOrder::STATE_ON_WAY],
                'callback_data' => '{"del":"'.ChatOrder::STATE_ON_WAY.'","o":'.$order->id.'}'
            ]);
            array_push($keyboard, [ $btn ]);
        } else if ($order->state == ChatOrder::STATE_ON_WAY) {
            $btn = Keyboard::button([
                'text' => $labels[ChatOrder::STATE_DELIVERED],
                'callback_data' => '{"del":"'.ChatOrder::STATE_DELIVERED.'","o":'.$order->id.'}'
            ]);
            array_push($keyboard, [ $btn ]);
        } else if ($order->state == ChatOrder::STATE_DELIVERED) {
            $btn = Keyboard::button([
                'text' => $labels[ChatOrder::STATE_COMPLATE],
                'callback_data' => '{"del":"'.ChatOrder::STATE_COMPLATE.'","o":'.$order->id.'}'
            ]);
            array_push($keyboard, [ $btn ]);
        }

        if ($order->state != ChatOrder::STATE_CANCEL) {
            $cancel = Keyboard::button([
                'text' => $labels[ChatOrder::STATE_CANCEL],
                'callback_data' => '{"del":"'.ChatOrder::STATE_CANCEL.'","o":'.$order->id.'}'
            ]);
            array_push($keyboard, [ $cancel ]);
        } else {
            $new = Keyboard::button([
                'text' => $labels[ChatOrder::STATE_NEW],
                'callback_data' => '{"del":"'.ChatOrder::STATE_NEW.'","o":'.$order->id.'}'
            ]);
            array_push($keyboard, [ $new ]);
        }

        $reply_markup = Keyboard::make([
            'inline_keyboard' => $keyboard,
        ]);

        return $reply_markup;
    }

    public static function bm24($amount)
    {
        $keyboard = [];
        $payme_url = PaymeHelper::bm24Link($amount);

        $payme = Keyboard::button([
            'text' => 'Payme',
            'url' => $payme_url
        ]);
        array_push($keyboard, [ $payme ]);

        $home = Keyboard::button([
            'text' => Lang::get('bot.btn_home'),
            'callback_data' => '{"home":"1"}'
        ]);
        array_push($keyboard, [ $home ]);

        $reply_markup = Keyboard::make([
            'inline_keyboard' => $keyboard,
        ]);

        return $reply_markup;
    }

    public static function addContact()
    {
        $contact = Keyboard::button([
            'text' => Lang::get('bot.send_your_phone_number'),
            'request_contact' => true
        ]);

        $home = Keyboard::button([
            'text' => Lang::get('bot.btn_home'),
        ]);

        $reply_markup = Keyboard::make([
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
            'keyboard' => [
                [ $contact ],
                [ $home ],
            ],
        ]);

        return $reply_markup;
    }

    public static function changeContact($phone, $back = 10)
    {
        $keyboard = [];
        // $phone = Keyboard::button([
        //     'text' => '+'.$phone,
        //     'callback_data' => '{"chan_ph":"1"}'
        // ]);
        // array_push($keyboard, [ $phone ]);

        $change = Keyboard::button([
            'text' => Lang::get('bot.btn_change_phone'),
            'callback_data' => '{"chan_ph":"1"}'
        ]);
        array_push($keyboard, [ $change ]);

        $back = Keyboard::button([
            'text' => Lang::get('bot.btn_back'),
            'callback_data' => '{"back":'.$back.'}'
        ]);
        array_push($keyboard, [ $back ]);

        $reply_markup = Keyboard::make([
            'inline_keyboard' => $keyboard,
        ]);

        return $reply_markup;
    }

}

?>
