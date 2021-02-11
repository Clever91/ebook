<?php

namespace App\Helpers\Common;

use App\Helpers\Bot\BotKeyboard;
use Exception;
use App\Helpers\Log\TelegramLog;
use App\Models\Admin\Setting;
use App\Models\Bot\ChatOrder;
use App\Models\Helpers\ClickTransaction;
use Illuminate\Support\Facades\Lang;
use Telegram\Bot\Laravel\Facades\Telegram;

class ClickHelper
{
    const SERVICE_ID = 17014;
    const MERCHANT_ID = 12320;
    const SECRET_KEY = 'lnNJ1ytZgTc';
    const MERCHANT_USER_ID = 18345;
    // const PREPARE_URL = "https://bookmedianashr.uz/pay/click/prepare";
    // const RETURN_URL = "https://bookmedianashr.uz/pay/click/complete";
    const API_ENDPOINT = "https://api.click.uz/v2/merchant/";

    public static function followingLink($amount, $order_id)
    {
        return "https://my.click.uz/services/pay?service_id=".
            self::SERVICE_ID."&merchant_id=".
            self::MERCHANT_ID."&amount=".
            $amount."&transaction_param=".$order_id;
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

    public static function run()
    {
        $data = request()->all();
        TelegramLog::log($data);

        if (empty($data))
            return ClickTransaction::getResponse($data, -8);

        if ($data['error'] != 0) {
            return ClickTransaction::getResponse($data, -8);
        }

        if ($data['action'] == ClickTransaction::ACTION_PREPARE) {
            if (!ClickHelper::checkSign($data)) {
                return ClickTransaction::getResponse($data, -1);
            }

            $order = ChatOrder::find($data['merchant_trans_id']);
            if (is_null($order)) {
                return ClickTransaction::getResponse($data, -5);
            }

            $model = ClickTransaction::create($data);
            if (!is_null($model)) {
                return ClickTransaction::getResponse($data, 0, $model->id);
            }

            return ClickTransaction::getResponse($data, -6);
        } else if ($data['action'] == ClickTransaction::ACTION_COMPLETE) {

            if (!ClickHelper::checkSign($data, $data['merchant_prepare_id'])) {
                return ClickTransaction::getResponse($data, -1);
            }

            $model = ClickTransaction::find($data['merchant_prepare_id']);
            if (is_null($model)) {
                return ClickTransaction::getResponse($data, -6);
            }

            $order = ChatOrder::find($data['merchant_trans_id']);
            if (is_null($order)) {
                $model->error = -5;
                $model->error_note = ClickTransaction::getErrorNote(-5);
                $model->save();
                return ClickTransaction::getResponse($data, -5);
            }

            $amount = $order->amountWithDelivery();
            if ($amount != $data['amount']) {
                $model->error = -2;
                $model->error_note = ClickTransaction::getErrorNote(-2);
                $model->save();
                return ClickTransaction::getResponse($data, -2);
            }

            // check ClickTransaction::ACTION_CANCEL

            if ($model->action == ClickTransaction::ACTION_COMPLETE) {
                $model->error = -4;
                $model->error_note = ClickTransaction::getErrorNote(-4);
                $model->save();
                return ClickTransaction::getResponse($data, -4);
            }

            $model->action = ClickTransaction::ACTION_COMPLETE;
            $model->error = 0;
            $model->error_note = ClickTransaction::getErrorNote(0);
            if ($model->save()) {
                $order->paid = ChatOrder::PAID_SUCCESS;
                $order->state = ChatOrder::STATE_NEW;
                $order->payment_type = ChatOrder::PAYMENT_CLICK;
                if ($order->save()) {

                    try {
                        // edit message reply markup
                        Telegram::editMessageReplyMarkup([
                            'chat_id' => $order->chat_id,
                            'message_id' => $order->message_id,
                            'inline_message_id' => $order->message_id,
                            'reply_markup' => false
                        ]);
                    } catch (Exception $e) {
                        TelegramLog::log($e->getMessage());
                    }

                    try {
                        $text = Lang::get('bot.thank_you_your_order_accepted') ." <b>". $order->id ."</b>";
                        if ($order->isPickUp())
                            $text .= "\n\n" .Lang::get("bot.our_geolocation");

                        $keyboard = BotKeyboard::home();

                        $response = Telegram::sendMessage([
                            'chat_id' => $order->chat_id,
                            'text' => $text,
                            'parse_mode' => "HTML",
                            'reply_markup' => $keyboard,
                            'reply_to_message_id' => $order->message_id
                        ]);

                        if ($order->isPickUp()) {
                            $lat = Setting::get('shop_lat');
                            $lng = Setting::get('shop_lng');
                            // send location
                            Telegram::sendLocation([
                                "chat_id" => $order->chat_id,
                                "latitude" => $lat,
                                "longitude" => $lng,
                                "horizontal_accuracy" => 50,
                                "reply_to_message_id" => $response->getMessageId()
                            ]);
                        }
                    } catch (Exception $e) {
                        TelegramLog::log($e->getMessage());
                    }

                    // ~~~~~~~~~~~~~~~~~ send group check

                    $group_id = Setting::get('order_group');
                    $text = $order->telegramOrderList();

                    try {
                        $response = Telegram::sendMessage([
                            'chat_id' => $group_id,
                            'text' => $text,
                            'parse_mode' => "HTML"
                        ]);
                        if (!$order->isPickUp()) {
                            $response = Telegram::sendLocation([
                                'chat_id' => $group_id,
                                'latitude' => $order->lat,
                                'longitude' => $order->long,
                                'reply_to_message_id' => $response->getMessageId()
                            ]);
                        }
                    } catch (Exception $e) {
                        TelegramLog::log($e->getMessage());
                    }

                    return ClickTransaction::getResponse($data, 0, null, $order->id);
                }
                return ClickTransaction::getResponse($data, -7);
            }
        } else {
            return ClickTransaction::getResponse($data, -3);
        }
    }

}
