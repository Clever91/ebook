<?php

namespace App\Helpers\Common;

use App\Models\Admin\Setting;
use App\Models\Bot\ChatOrder;
use Illuminate\Support\Facades\Storage;

class Fargo
{
    const FILENAME = "fargo_prices.txt";

    const KEY_CITY = "CITY";
    const KEY_OFFICE_OFFICE = "OFFICE_OFFICE";
    const KEY_OFFICE_DOOR = "OFFICE_DOOR";

    public static function savePrices($content = [])
    {
        if (empty($content)) {
            $content = [
                self::KEY_CITY => [
                    "name" => "По Городу",
                    "code" => ChatOrder::DELIVERY_FARGO_CITY,
                    "zero" => 15000,
                    "price" => 5000,
                    "step" => 3,
                ],
                self::KEY_OFFICE_OFFICE => [
                    "name" => "До Пункта Fargo",
                    "code" => ChatOrder::DELIVERY_FARGO_OFFICE,
                    "zero" => 0,
                    "price" => 5000,
                    "step" => 1,
                ],
                self::KEY_OFFICE_DOOR => [
                    "name" => "До Двери",
                    "code" => ChatOrder::DELIVERY_FARGO_DOOR,
                    "zero" => 20000,
                    "price" => 5000,
                    "step" => 1,
                ],
            ];
        }
        Storage::disk('local')->put(self::FILENAME, json_encode($content));
        return $content;
    }

    public static function getPrices()
    {
        if (Storage::disk('local')->exists(self::FILENAME)) {
            $content = Storage::disk('local')->get(self::FILENAME);
            return json_decode($content, true);
        }
        return [];
    }

    public static function getPrice($weight, $type = "OFFICE_OFFICE")
    {
        $content = self::getPrices();
        // min price
        if ($weight < 1)
            $weight = 1;
        // NDS
        $nds = Setting::get("delivery_nds") / 100 + 1;
        // calculate
        if (isset($content[$type])) {
            $key = $type;
            $step = $content[$type]["step"];
            $zero = (float) $content[$type]["zero"];
            $price = (float) $content[$type]["price"];
            if ($key == "CITY") {
                $weight = ceil($weight);
                $num = (int) ($weight / $step);
                if ($weight % $step !== 0)
                    $num = $num + 1;
                return ($num * $price + $zero) * $nds;
            } else {
                return ($weight * $price + $zero) * $nds;
            }
        }

        return  0;
    }

    public static function isKeyToFargo($key)
    {
        return in_array($key, self::getKeys());
    }

    public static function getKeys()
    {
        return [ self::KEY_CITY, self::KEY_OFFICE_OFFICE, self::KEY_OFFICE_DOOR ];
    }
}
