<?php

namespace App\Helpers\Common;

use App\Models\Admin\Setting;
use App\Models\Bot\ChatOrder;
use App\Models\Bot\ChatUser;

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

    /**
     * Calculates the great-circle distance between two points, with
     * the Haversine formula.
     * @param float $latitudeFrom Latitude of start point in [deg decimal]
     * @param float $longitudeFrom Longitude of start point in [deg decimal]
     * @param float $latitudeTo Latitude of target point in [deg decimal]
     * @param float $longitudeTo Longitude of target point in [deg decimal]
     * @param float $earthRadius Mean earth radius in [m]
     * @return float Distance between points in [m] (same as earthRadius)
     */
    public static function haversineGreatCircleDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }

    public static function showCashPayment($distance = null)
    {
        if (is_null($distance))
            return true;
        $min_distance = Setting::get('min_distance_for_cash');
        return $distance <= $min_distance;
    }

    public static function showPaid($payment_type)
    {
        return in_array($payment_type, [ ChatOrder::PAYMENT_CASH, ChatOrder::PAYMENT_BM24]);
    }

    public static function sendableState($state)
    {
        return in_array($state, [ChatOrder::STATE_ON_WAY, ChatOrder::STATE_DELIVERED, ChatOrder::STATE_CANCEL]);
    }

    public static function getLastOrder($chat_id)
    {
        $lastOrder = ChatOrder::where([
            [ 'chat_id', '=', $chat_id ],
            [ 'state', '<>', ChatOrder::STATE_DRAF],
        ])->whereNotNull("lat")->whereNotNull('long')
        ->orderByDesc('id')->first();
        return $lastOrder;
    }

    public static function createChatUser($chat, $locale = "ru")
    {
        if (!empty($chat) && !is_null($chat)) {
            $chatUser = ChatUser::where('chat_id', $chat->getId())->first();
            if (is_null($chatUser)) {
                $attributes['chat_id'] = $chat->getId();
                $attributes['first_name'] = $chat->getFirstName();
                $attributes['last_name'] = $chat->getLastName();
                $attributes['username'] = $chat->getUsername();
                $attributes['language_code'] = $locale;
                $attributes['locale'] = $locale;
                $chatUser = ChatUser::create($attributes);
            } else {
                $chatUser->locale = $locale;
                $chatUser->save();
            }
        }
    }

    public static function firstUpperStr($string)
    {
        return strtoupper(mb_substr($string, 0, 1));
    }
}


?>
