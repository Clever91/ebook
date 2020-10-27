<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use App\Models\Bot\ChatGroup;
use Exception;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
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
        $this->log($message);

        if (!is_null($message)) {
            $command = $message->getText();
            $chat = $message->getChat();
            $from = $message->getFrom();
            $contact = $message->getContact();
            $new_member = $message->getNewChatParticipant();
            $left_member = $message->getLeftChatParticipant();
            // $this->log($participant);

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
                            // $this->log($new_member->isBot());
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
                                    $this->log($e->getMessage());
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

                }
            }
        }

        return ;
    }

    private function log($msg = "")
    {
        Telegram::sendMessage([
            'chat_id' => 122420625, 
            'text' => json_encode($msg)
        ]);
    }
}
