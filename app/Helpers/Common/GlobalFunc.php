<?php

namespace App\Helpers\Common;


class GlobalFunc
{
    public static function moneyFormat($number, $currency = "сум")
    {
        return number_format((float) $number, 0) . " " . $currency;
    }

    public static function removePlus($phone) 
    {
        return preg_replace('/\D+/', '', $phone);
    }
}


?>