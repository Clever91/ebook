<?php

namespace App\Helpers\Common;

use App\Helpers\Log\TelegramLog;
use Illuminate\Support\Facades\Http;

class ClickHelper
{
    const SERVICE_ID = 17014;
    const MERCHANT_ID = 12320;
    const SECRET_KEY = 'lnNJ1ytZgTc';
    const MERCHANT_USER_ID = 18345;
    const PREPARE_URL = "https://bookmedianashr.uz/pay/payme/prepare";
    const RETURN_URL = "https://bookmedianashr.uz/pay/payme/complete";
    const API_ENDPOINT = "https://api.click.uz/v2/merchant/";

    public static function followingLink($amount, $order_id)
    {
        return "https://my.click.uz/services/pay?service_id=".
            self::SERVICE_ID."&merchant_id=".
            self::MERCHANT_ID."&amount=".
            $amount."&transaction_param=".
            $order_id."&return_url=".
            self::RETURN_URL;
    }

    public static function checkSign($data, $merchant_prepare_id = null)
    {
        if (!isset($data['service_id']) || self::SERVICE_ID != $data['service_id']) {
            return false;
        }

        $sign_string = md5($data['click_trans_id'] . self::SERVICE_ID . self::SECRET_KEY .
         $data['merchant_trans_id'] . $merchant_prepare_id . $data['amount'] . $data['action'] . $data['sign_time']);

        if ($sign_string != $data['sign_string']) {
            return false;
        }

        return true;
    }

}