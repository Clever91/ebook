<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Bot\BotKeyboard;
use Exception;
use App\Helpers\Log\TelegramLog;
use App\Http\Controllers\Controller;
use App\Models\Admin\Setting;
use App\Models\Bot\ChatOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Telegram\Bot\Laravel\Facades\Telegram;

class ChatOrderController extends Controller
{
    public function index()
    {
        $models = ChatOrder::orderByDesc('id')->get();
            // ->paginate(15);
        return view('admin.chatOrder.index', compact('models'));
    }

    public function detail(Request $request, $order_id)
    {
        $model = ChatOrder::findOrFail($order_id);
        $print = $request->input('print', false);
        $chatUser = $model->chatUser();
        if (is_null($chatUser))
            return back();
        return view('admin.chatOrder.detail', [
            'model' => $model,
            'isPrint' => $print,
            'chatUser' => $chatUser,
        ]);
    }

    public function sendToTelegram(Request $request, $order_id)
    {
        // set default language
        $locale = env('LANG_DEFAULT') || "ru";
        App::setLocale($locale);
        $group_id = Setting::get('order_group');
        $order = ChatOrder::findOrFail($order_id);
        $text = $order->telegramOrderList();
        $keyboard = BotKeyboard::status($order);

        try {
            $response = Telegram::sendMessage([
                'chat_id' => $group_id,
                'text' => $text,
                'parse_mode' => "HTML",
                'reply_markup' => $keyboard,
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
