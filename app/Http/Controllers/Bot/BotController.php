<?php

namespace App\Http\Controllers\Bot;

use Exception;
use App\Helpers\Bot\BotKeyboard;
use App\Helpers\Log\TelegramLog;
use App\Http\Controllers\Controller;
use App\Models\Bot\ChatGroup;
use App\Models\Bot\ChatPost;
use App\Models\Product;
use Illuminate\Http\Request;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotController extends Controller
{
    public function getMe()
    {
        $response = Telegram::getMe();
        return $response;
    }

    public function getInfo()
    {
        $response = Telegram::getWebhookInfo();
        return $response;
    }

    public function getUpdate()
    {
        $response = Telegram::getUpdates();
        return $response;
    }

    public function removeWebhook()
    {
        $response = Telegram::removeWebhook();
        return $response;
    }

    public function setWebhook()
    {
        $response = Telegram::setWebhook([
            'url' => "https://bookmedianashr.uz/api/bot"
        ]);
        return $response;
    }

    public function index(Request $request)
    {
        $response = Telegram::getWebhookUpdates();
        $message = $response->getMessage();
        $callback = $response->getCallbackQuery();

        if (!is_null($callback)) {

            $data = $callback->getData();
            $message = $callback->getMessage();
            $from = $callback->getFrom();

            if (!is_null($message)) {

                $chat = $message->getChat();
                $message_id = $message->getMessageId();
                $caption = $message->getCaption();
                // $reply_markup = $message->getReplyMarkup();

                if (!is_null($chat) && $chat->getType() == "private") {
                    
                    $chat_id = $from->getId();
                    $decode = json_decode($data);

                    if ($decode->btn == "add") {

                        $number = intval($decode->num) + 1;
                        $product_id = $decode->pro;

                        $product = Product::find($product_id);
                        if (!is_null($product)) {
                            try {
                                
                                $reply_markup = BotKeyboard::product($product->id, $number);
                                
                                // edit message reply markup
                                Telegram::editMessageCaption([
                                    'chat_id' => $chat_id,
                                    'message_id' => $message_id,
                                    'inline_message_id' => $message_id,
                                    'caption' => $caption,
                                    'parse_mode' => "Markdown",
                                    'reply_markup' => $reply_markup
                                ]);
    
                            } catch (Exception $e) {
                                TelegramLog::log($e->getMessage());
                            }
                        } else {
                            TelegramLog::log("Product is not found: " . $decode->pro);
                        }
                        
                    } else if ($decode->btn == "sub") {
                        
                        $number = intval($decode->num) - 1;
                        $product_id = $decode->pro;

                        $product = Product::find($product_id);
                        if (!is_null($product)) {
                            try {
                                
                                $reply_markup = BotKeyboard::product($product->id, $number);
                                
                                // edit message reply markup
                                Telegram::editMessageCaption([
                                    'chat_id' => $chat_id,
                                    'message_id' => $message_id,
                                    'inline_message_id' => $message_id,
                                    'caption' => $caption,
                                    'parse_mode' => "Markdown",
                                    'reply_markup' => $reply_markup
                                ]);
    
                            } catch (Exception $e) {
                                TelegramLog::log($e->getMessage());
                            }
                        } else {
                            TelegramLog::log("Product is not found: " . $decode->pro);
                        }
                    }
                }
            }

        } else if (!is_null($message)) {
            $command = $message->getText();
            $chat = $message->getChat();
            $from = $message->getFrom();
            $contact = $message->getContact();
            $new_member = $message->getNewChatParticipant();
            $left_member = $message->getLeftChatParticipant();

            if (!is_null($chat)) {
                $chat_id = $chat->getId();
                $type = $chat->getType();
                $title = $chat->getTitle();
                $all_admin = $chat->getAllMembersAreAdministrators();

                if ($type == "group" || $type == "supergroup") {
                    
                    // check if new bot added to group
                    if (!is_null($new_member)) {

                        // add group_id when own bot is added to group
                        $username = $new_member->getUsername();
                        if ($username == env("TELEGRAM_BOT_USERNAME")) {

                            // save group_id
                            $chatGroup = ChatGroup::where(['chat_id' => $chat_id])->first();
    
                            if (is_null($chatGroup)) {
    
                                $from_id = $from->getId();
                                $firstname = $from->getFirstName();
    
                                try {
                                    // create new 
                                    ChatGroup::create([
                                        'chat_id' => $chat_id,
                                        'title' => $title,
                                        'all_admin' => $all_admin,
                                        'from_id' => $from_id
                                    ]);
    
                                    // send message
                                    Telegram::sendMessage([
                                        'chat_id' => $chat_id,
                                        'text' => "Rahmat *$firstname* mani qo'shganingiz uchun  👍",
                                        'parse_mode' => "Markdown"
                                    ]);
    
                                } catch (Exception $e) {
                                    TelegramLog::log($e->getMessage());
                                }
                            }
                        }
                    }

                    // check if bot is deleted 
                    if (!is_null($left_member)) {

                        // remove group_id when own bot is removed from group
                        $username = $left_member->getUsername();
                        if ($username == env("TELEGRAM_BOT_USERNAME")) {
                        
                            // delete group_id
                            $chatGroup = ChatGroup::where(['chat_id' => $chat_id])->first();
                            if (!is_null($chatGroup)) {
                                $chatGroup->delete();
                            }
                        }

                    }

                } else if ($type == "private") {

                    // agar tavarni posti bo'lsa
                    if (strpos($command, "product")) {

                        $str = explode("-", $command);
                        $product_id = $str[1];
                        $product = Product::find($product_id);

                        if (!is_null($product)) {
                            $post = ChatPost::where(['product_id' => $product->id])
                                ->orderByDesc("created_at")->first();
                            $thumbnail = $product->image->getImageUrl("500x500");
                            $url = "https://".$request->getHttpHost() . "" . $thumbnail;
                            $caption = $post->caption;
    
                            try {
    
                                $reply_markup = BotKeyboard::product($product->id, 1);
    
                                // send message
                                Telegram::sendPhoto([
                                    'chat_id' => $chat_id,
                                    'photo' => new InputFile($url),
                                    'caption' => $caption,
                                    'parse_mode' => "Markdown",
                                    'reply_markup' => $reply_markup
                                ]);
    
                            } catch (Exception $e) {
                                TelegramLog::log($e->getMessage());
                            }
                        } else {
                            TelegramLog::log("Product is not found: " . $command);
                        }
                    }
                }
            }
        }

        // header ( 'Content-Type:application/json' );
        // echo '{"ok":true, "retry_after": 1}';
        return ["ok" => true];
    }
}
