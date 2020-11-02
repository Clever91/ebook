<?php

namespace App\Helpers\Log;

use Exception;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramLog
{
    public static function log($arr, $chat_id = -388129393)
    {
        try {

            Telegram::sendMessage([
                'chat_id' => $chat_id, 
                'text' => json_encode($arr)
            ]);

        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public static function handler($msg, $chat_id = 122420625)
    {
        try {

            Telegram::sendMessage([
                'chat_id' => $chat_id, 
                'text' => $msg,
                'parse_mode' => "Markdown",
            ]);

        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }
}


?>