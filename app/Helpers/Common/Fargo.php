<?php

namespace App\Helpers\Common;

use Illuminate\Support\Facades\Storage;

class Fargo
{
    const FILENAME = "fargo_prices.txt";

    public static function savePrices($content = [])
    {
        if (empty($content)) {
            $content = [
                "OFFICE_OFFICE" => 5750,
                "DOOR_DOOR" => 28750,
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

    public static function getPrice($weight = 1, $type = "OFFICE_OFFICE")
    {
        $content = self::getPrices();
        // min price
        if ($weight < 1)
            $weight = 1;
        return isset($content[$type]) ? $content[$type] * $weight : 0;
    }
}
