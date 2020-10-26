<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram\Bot\Api;

class BotController extends Controller
{
    public function getMe()
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $response = $telegram->getMe();
        return $response;
    }

    public function getInfo()
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $response = $telegram->getWebhookInfo();
        return $response;
    }

    public function index(Request $request)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $response = $telegram->getWebhookUpdates();
        // $this->log($response);
        $message = $response->getMessage();
        $callback = $response->getCallbackQuery();
        return $response;
    }

    // private function log($msg = "")
    // {
    //     Telegram::sendMessage([
    //         'chat_id' => 122420625, 
    //         'text' => json_encode($msg)
    //     ]);
    // }
}
