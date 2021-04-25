<?php

namespace App\Helpers\Common;

use App\Models\Admin\Setting;
use Illuminate\Support\Facades\Storage;

class Fargo
{
    const FILENAME = "fargo_prices.txt";

    public static function savePrices($content = [])
    {
        if (empty($content)) {
            $content = [
                "CITY" => [
                    "name" => "По Городу",
                    "key" => "CITY",
                    "zero" => 15000,
                    "price" => 5000,
                    "step" => 3,
                ],
                "OFFICE_OFFICE" => [
                    "name" => "До Пункта Fargo",
                    "key" => "OFFICE_OFFICE",
                    "zero" => 0,
                    "price" => 5000,
                    "step" => 1,
                ],
                "OFFICE_DOOR" => [
                    "name" => "До Двери",
                    "key" => "OFFICE_DOOR",
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
            $key = $content[$type]["key"];
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
}
