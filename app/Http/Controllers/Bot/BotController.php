<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotController extends Controller
{
    public function index(Request $request)
    {
        $response = Telegram::getWebhookUpdates();
        $this->log($response);
        // $message = $response->getMessage();
        // $callback = $response->getCallbackQuery();

        $response = Telegram::getMe();
        $this->log($response);

        $botId = $response->getId();
        $firstName = $response->getFirstName();
        $username = $response->getUsername();
    }

    private function log($msg = "")
    {
        Telegram::sendMessage([
            'chat_id' => 122420625, 
            'text' => json_encode($msg)
        ]);
    }
}
