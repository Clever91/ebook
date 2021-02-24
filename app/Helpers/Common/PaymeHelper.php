<?php

namespace App\Helpers\Common;

use App\Helpers\Log\TelegramLog;

class PaymeHelper
{
    const MERCHANT_KEY = '5fb811504ef128e66ee32ab5';
    const RETURN_URL = "https://admin.bookmarker24.uz/pay/payme/complete";
    const URL = "https://checkout.paycom.uz";

    public static function followingLink($amount, $order_id)
    {
        $encode = base64_encode('m='.self::MERCHANT_KEY.';ac.order_id='.$order_id.';a='.($amount * 100).';c='.self::RETURN_URL);
        return self::URL . "/" . $encode;
    }

    public static function run()
    {
        $data = request()->all();
        TelegramLog::log($data);
    }

}
