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

    public static function followingLink($amount)
    {
        return "https://my.click.uz/services/pay?service_id=".
            self::SERVICE_ID."&merchant_id=".
            self::MERCHANT_ID."&amount=".
            $amount."&transaction_param=998900354477&return_url=".
            self::RETURN_URL;
    }

    public static function createInvoice($phone, $amount = 0, $order_id)
    {
        $auth = self::MERCHANT_USER_ID . sha1(time() . self::SECRET_KEY) . time();
        // Digest authentication...
        $response = Http::withHeaders([
                'Auth' => $auth,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(self::API_ENDPOINT, [
                'service_id' => self::SERVICE_ID,
                'amount' => $amount,
                'phone_number' => $phone,
                'merchant_trans_id' => $order_id,
            ]);
        
        if ($response->successful()) {
            TelegramLog::log($response->json());
        } else if ($response->failed()) {
            TelegramLog::log($response->json());
        }
    }

}