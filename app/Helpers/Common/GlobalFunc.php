<?php

namespace App\Helpers\Common;


class GlobalFunc
{
    public static function moneyFormat($number, $currency = "сум")
    {
        return number_format((float) $number, 0) . " " . $currency;
    }
}


?>