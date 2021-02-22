<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Helpers\Log\TelegramLog;
use App\Http\Controllers\Controller;
use App\Models\Admin\Setting;
use App\Models\Bot\ChatOrder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class ChatOrderController extends Controller
{
    public function index()
    {
        $models = ChatOrder::orderByDesc('id')->paginate(15);
        return view('admin.chatOrder.index', compact('models'));
    }

    public function sendToTelegram(Request $request, $order_id)
    {
        // set default language
        $locale = env('LANG_DEFAULT') || "ru";
        App::setLocale($locale);
        $group_id = Setting::get('order_group');
        $order = ChatOrder::findOrFail($order_id);
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
        return redirect()->route('admin.chat.order.index');
    }
}
