<?php

namespace App\Helpers\Common;


class GlobalFunc
{
    public static function moneyFormat($number, $currency = "сум")
    {
        if (is_null($currency) || $currency == false)
            return number_format((float) $number, 0);

        return number_format((float) $number, 0) . " " . $currency;
    }

    public static function removePlus($phone)
    {
        return preg_replace('/\D+/', '', $phone);
    }
}


?>
