<?php

namespace App\Helpers\Log;

use Exception;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramLog
{
    public static function log($msg, $chat_id = 122420625)
    {
        try {

            Telegram::sendMessage([
                'chat_id' => $chat_id, 
                'text' => json_encode($msg)
            ]);

        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }
}


?>