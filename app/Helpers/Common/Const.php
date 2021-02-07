<?php

namespace App\Helpers\Common;


class Const
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
