<?php

namespace App\Helpers\Common;

class ClickHelper
{
    const SERVICE_ID = 17014;
    const MERCHANT_ID = 12320;
    const SECRET_KEY = 'lnNJ1ytZgTc';
    const MERCHANT_USER_ID = 18345;
    const PREPARE_URL = "https://bookmedianashr.uz/pay/payme/prepare";
    const RETURN_URL = "https://bookmedianashr.uz/pay/payme/complete";

    public static function followingLink($amount)
    {
        return "https://my.click.uz/services/pay?service_id=".
            self::SERVICE_ID."&merchant_id=".
            self::MERCHANT_ID."&amount=".
            $amount."&transaction_param=998900354477&return_url=".
            self::RETURN_URL;
    }

}