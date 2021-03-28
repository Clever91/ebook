<?php

namespace App\Http\Controllers\Bot;

use Exception;
use App\Helpers\Bot\BotKeyboard;
use App\Helpers\Common\GlobalFunc;
use App\Helpers\Common\PaymeHelper;
use App\Helpers\Common\Sms;
use App\Helpers\Common\Step;
use App\Helpers\Log\TelegramLog;
use App\Http\Controllers\Controller;
use App\Models\Admin\Book;
use App\Models\Admin\Setting;
use App\Models\Bot\ChatGroup;
use App\Models\Bot\ChatOrder;
use App\Models\Bot\ChatOrderDetail;
use App\Models\Bot\ChatPost;
use App\Models\Admin\Category;
use App\Models\Admin\Customer;
use App\Models\Admin\Product;
use App\Models\Bot\ChatUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;
use Throwable;

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

    public function index(Request $request)
    {
        $response = Telegram::getWebhookUpdates();
        $message = $response->getMessage();
        $callback = $response->getCallbackQuery();
        $preCheckQuery = $response->getPreCheckoutQuery();
        // TelegramLog::log($response);

        if (!is_null($preCheckQuery)) {

            $id = $preCheckQuery->getId();
            $from = $preCheckQuery->getFrom();
            $total = $preCheckQuery->getTotalAmount();
            $payload = $preCheckQuery->getInvoicePayload();
            $info = $preCheckQuery->getOrderInfo();
            // $name = $info->getName();
            // $phone = $info->getPhoneNumber();

            try {
                Telegram::answerPreCheckoutQuery([
                    "pre_checkout_query_id" => $id,
                    "ok" => true,
                    // "error_message" => ""
                ]);
            } catch (Exception $e) {
                TelegramLog::log($e->getMessage());
            }

        } else if (!is_null($callback)) {

            $callback_id = $callback->getId();
            $data = $callback->getData();
            $message = $callback->getMessage();
            $from = $callback->getFrom();

            if (!is_null($message)) {

                $chat = $message->getChat();
                $message_id = $message->getMessageId();
                $caption = $message->getCaption();
                // $reply_markup = $message->getReplyMarkup();

                if (!is_null($chat) && $chat->getType() == "private") {

                    $chat_id = $chat->getId();
                    $decode = json_decode($data);
                    // set language
                    $locale = "ru";
                    $chatUser = ChatUser::where('chat_id', $chat_id)->first();
                    if (!is_null($chatUser)) {
                        $locale = $chatUser->locale;
                    } else {
                        GlobalFunc::createChatUser($chat);
                    }
                    App::setLocale($locale);

                    if (isset($decode->btn) && $decode->btn == "add") {

                        $product_id = $decode->pro;
                        $number = intval($decode->num) + 1;
                        $book = Book::find($decode->b_id);
                        try {
                            $reply_markup = BotKeyboard::product($product_id, $number, $locale, $book);
                            // edit message reply markup
                            Telegram::editMessageReplyMarkup([
                                'chat_id' => $chat_id,
                                'message_id' => $message_id,
                                'inline_message_id' => $message_id,
                                // 'caption' => $caption,
                                'parse_mode' => "Markdown",
                                'reply_markup' => $reply_markup
                            ]);
                        } catch (Exception $e) {
                            TelegramLog::log($e->getMessage());
                        }

                    } else if (isset($decode->btn) && $decode->btn == "sub") {

                        $product_id = $decode->pro;
                        $number = intval($decode->num);
                        $book = Book::find($decode->b_id);
                        if ($number > 1) {
                            $number -= 1;
                            try {
                                $reply_markup = BotKeyboard::product($product_id, $number, $locale, $book);
                                // edit message reply markup
                                Telegram::editMessageReplyMarkup([
                                    'chat_id' => $chat_id,
                                    'message_id' => $message_id,
                                    'inline_message_id' => $message_id,
                                    'parse_mode' => "Markdown",
                                    'reply_markup' => $reply_markup
                                ]);
                            } catch (Exception $e) {
                                TelegramLog::log($e->getMessage());
                            }
                        } else {
                            $message = Lang::get("bot.aler_min_product");
                            try {
                                $params = BotKeyboard::alert($callback, $message);
                                Telegram::answerCallbackQuery($params);
                            } catch (Exception $e) {
                                TelegramLog::log($e->getMessage());
                            }
                        }
                    } else if (isset($decode->add) || isset($decode->remove) || isset($decode->cart)) {
                        // update step to cart
                        if (!is_null($chatUser)) {
                            $chatUser->step = Step::CART;
                            $chatUser->save();
                        }

                        // check already exists
                        $order = ChatOrder::where([
                            "chat_id" => $chat_id,
                            "state" => ChatOrder::STATE_DRAF
                        ])->first();

                        if (isset($decode->remove)) {
                            $detail = ChatOrderDetail::find($decode->remove);
                            if (!is_null($detail)) {
                                $detail->delete();
                            }
                        } else if (isset($decode->pro) && isset($decode->num)){
                            $product_id = $decode->pro;
                            $number = intval($decode->num);
                            $product = Product::find($product_id);
                            $book = Book::find($decode->b_id);
                            if (!is_null($product) && !is_null($book)) {
                                if (is_null($order)) {
                                    // create new order
                                    $order = ChatOrder::create([
                                        "chat_id" => $chat_id,
                                        "state" => ChatOrder::STATE_DRAF
                                    ]);
                                    if (!is_null($order)) {
                                        // create detail
                                        $detail = ChatOrderDetail::create([
                                            "chat_order_id" => $order->id,
                                            "product_id" => $product->id,
                                            "book_id" => $book->id,
                                            "price" => $book->getPrice(),
                                            "quantity" => $number,
                                        ]);
                                    }
                                } else {
                                    $detail = ChatOrderDetail::where([
                                        "chat_order_id" => $order->id,
                                        "product_id" => $product->id,
                                        "book_id" => $book->id,
                                    ])->first();
                                    if (is_null($detail)) {
                                        // create detail
                                        $detail = ChatOrderDetail::create([
                                            "chat_order_id" => $order->id,
                                            "product_id" => $product->id,
                                            "book_id" => $book->id,
                                            "price" => $book->getPrice(),
                                            "quantity" => $number,
                                        ]);
                                    } else {
                                        $detail->quantity += $number;
                                        $detail->save();
                                    }
                                }
                            } else {
                                try {
                                    Telegram::sendMessage([
                                        'chat_id' => $chat_id,
                                        'text' => Lang::get('bot.this_product_is_not_active')
                                    ]);
                                } catch (Exception $e) {
                                    TelegramLog::log($e->getMessage());
                                }
                            }
                        }

                        if (is_null($order) || $order->details->count() < 1) {
                            Telegram::answerCallbackQuery([
                                "callback_query_id" => $callback_id,
                                "text" => Lang::get('bot.empty_cart'),
                                "show_alert" => true
                            ]);

                            if (isset($decode->remove) || isset($decode->cart)) {
                                $text = Lang::get("bot.select_category");
                                $categories = Category::where([
                                    'status' => Category::STATUS_ACTIVE,
                                    'deleted' => Category::NO_DELETED
                                ])->orderBy('order_no')->get();

                                try {
                                    $reply_markup = BotKeyboard::categories($categories);
                                    // edit message reply markup
                                    Telegram::sendMessage([
                                        "chat_id" => $chat_id,
                                        "text" => $text,
                                        "parse_mode" => "Markdown",
                                        "reply_markup" => $reply_markup
                                    ]);
                                } catch (Exception $e) {
                                    TelegramLog::log($e->getMessage());
                                }
                            }
                        } else {
                            // cart list
                            try {
                                $total = 0;
                                $details = $order->details;
                                $text = Lang::get("bot.your_cart");
                                foreach($details as $index => $detail) {
                                    $amount = $detail->price * $detail->quantity;
                                    $text .= ($index+1) .". <b>". $detail->product->translateorNew($locale)->name ." (";
                                    if (!is_null($detail->book))
                                        $text .= $detail->book->getBtnLabel($locale) .")</b>\n";
                                    $text .= "✏️   <i>" . GlobalFunc::moneyFormat($detail->price, false) ."</i> x "
                                    . $detail->quantity ." = <i>";
                                    $text .= GlobalFunc::moneyFormat($amount)."</i>\n";
                                    $total += $amount;
                                }
                                $text .= "\n".Lang::get('bot.total')." ".GlobalFunc::moneyFormat($total);
                                $reply_markup = BotKeyboard::cart($details, 2);
                                // edit message reply markup
                                Telegram::sendMessage([
                                    "chat_id" => $chat_id,
                                    "text" => $text,
                                    "parse_mode" => "HTML",
                                    "reply_markup" => $reply_markup
                                ]);

                            } catch (Exception $e) {
                                TelegramLog::log($e->getMessage());
                            }
                        }

                        try {
                            // remove message reply markup
                            Telegram::editMessageReplyMarkup([
                                'chat_id' => $chat_id,
                                'message_id' => $message_id,
                                'inline_message_id' => $message_id,
                                'parse_mode' => "Markdown",
                                'reply_markup' => false
                            ]);
                        } catch (Exception $e) {
                            TelegramLog::log($e->getMessage());
                        }
                    } else if (isset($decode->back) && $decode->back == 3) {
                        // check already exists
                        $order = ChatOrder::where([
                            "chat_id" => $chat_id,
                            "state" => ChatOrder::STATE_DRAF
                        ])->first();
                        if (!is_null($order)) {
                            try {
                                $reply_markup = BotKeyboard::cart($order->details, 2);
                                // edit message reply markup
                                Telegram::editMessageReplyMarkup([
                                    'chat_id' => $chat_id,
                                    'message_id' => $message_id,
                                    'inline_message_id' => $message_id,
                                    'parse_mode' => "HTML",
                                    'reply_markup' => $reply_markup
                                ]);

                            } catch (Exception $e) {
                                TelegramLog::log($e->getMessage());
                            }
                        }
                    }
                    // else if (isset($decode->del)) {
                    //     $type = $decode->del;
                    //     // get chat order
                    //     $order = ChatOrder::where([
                    //         "chat_id" => $chat_id,
                    //         "state" => ChatOrder::STATE_DRAF
                    //     ])->first();

                    //     if (!is_null($order)) {
                    //         $order->delivery_type = $type;
                    //         $order->save();
                    //         if ($type == ChatOrder::DELIVERY_PICKUP) {
                    //             $text = Lang::get("bot.send_phone");
                    //             try {
                    //                 $reply_markup = BotKeyboard::contact();
                    //                 // edit message reply markup
                    //                 Telegram::sendMessage([
                    //                     "chat_id" => $chat_id,
                    //                     "text" => $text,
                    //                     "parse_mode" => "Markdown",
                    //                     "reply_markup" => $reply_markup
                    //                 ]);

                    //             } catch (Exception $e) {
                    //                 TelegramLog::log($e->getMessage());
                    //             }
                    //         } else {
                    //             // get last order
                    //             $lastOrder = GlobalFunc::getLastOrder($chat_id);
                    //             $text = Lang::get("bot.send_location");
                    //             // update step
                    //             $chatUser->step = Step::LAST_ORDER;
                    //             $chatUser->save();
                    //             try {
                    //                 $reply_markup = BotKeyboard::location($lastOrder);
                    //                 // edit message reply markup
                    //                 Telegram::sendMessage([
                    //                     "chat_id" => $chat_id,
                    //                     "text" => $text,
                    //                     "reply_markup" => $reply_markup
                    //                 ]);

                    //             } catch (Exception $e) {
                    //                 TelegramLog::log($e->getMessage());
                    //             }
                    //         }

                    //         // edit message reply markup
                    //         try {
                    //             Telegram::editMessageReplyMarkup([
                    //                 'chat_id' => $chat_id,
                    //                 'message_id' => $message_id,
                    //                 'inline_message_id' => $message_id,
                    //                 'parse_mode' => "HTML",
                    //                 'reply_markup' => false
                    //             ]);
                    //         } catch (Exception $e) {
                    //             TelegramLog::log($e->getMessage());
                    //         }
                    //     } else {
                    //         TelegramLog::log("Order is not found: chat_id = " . $chat_id);
                    //     }

                    // }
                    else if (isset($decode->pay)) {

                        $type = $decode->type;
                        // bm24: this is payme, We made it custom btn
                        if ($type == "cash" || $type == "bm24") {
                            // check order exists
                            $order = ChatOrder::where([
                                "chat_id" => $chat_id,
                                "state" => ChatOrder::STATE_DRAF
                            ])->first();

                            if (!is_null($order)) {
                                $delivery = 0;
                                if (!$order->isPickUp())
                                    $delivery = (float) Setting::get("delivery_price");

                                $order->payment_type = ChatOrder::PAYMENT_CASH;
                                if ($type == "bm24")
                                    $order->payment_type = ChatOrder::PAYMENT_BM24;
                                $order->delivery_price = $delivery;
                                $order->state = ChatOrder::STATE_NEW;
                                if ($order->save()) {

                                    $details = ChatOrderDetail::where([
                                        "chat_order_id" => $order->id
                                    ])->get();

                                    $total = 0;
                                    foreach($details as $detail) {
                                        $total += $detail->price * $detail->quantity;
                                    }
                                    $order->amount = $total;
                                    $order->save();

                                    try {
                                        // edit message reply markup
                                        Telegram::editMessageReplyMarkup([
                                            'chat_id' => $chat_id,
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

                                        if ($type == "bm24") {
                                            $text .= "\n\n" .Lang::get("bot.bm24_text");
                                        }
                                        $keyboard = BotKeyboard::home();
                                        if ($type == "bm24") {
                                            $amount = $order->amountWithDelivery();
                                            $keyboard = BotKeyboard::bm24($amount);
                                        }

                                        $response = Telegram::sendMessage([
                                            'chat_id' => $order->chat_id,
                                            'text' => $text,
                                            'parse_mode' => "HTML",
                                            'reply_markup' => $keyboard,
                                            'reply_to_message_id' => $order->message_id
                                        ]);

                                        if ($type == "bm24") {
                                            // save message ID, after payme (bm24) to remove last message
                                            $order->message_id = $response->getMessageId();
                                            $order->save();
                                        }

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

                                    // create order
                                    // $order->createOrder($chatUser);

                                    // ~~~~~~~~~~~~~~~~~ send group check

                                    // set default language
                                    $locale = env('LANG_DEFAULT') || "ru";
                                    App::setLocale($locale);
                                    $group_id = Setting::get('order_group');
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
                                }
                            }

                        } else {

                            $bot_token = env("CLICK_BOT_TOKEN");
                            if ($type == "payme")
                                $bot_token = env("PAYME_BOT_TOKEN");

                            try {
                                // check order exists
                                $order = ChatOrder::where([
                                    "chat_id" => $chat_id,
                                    "state" => ChatOrder::STATE_DRAF
                                ])->first();

                                if (!is_null($order)) {

                                    // save payment type
                                    $order->payment_type = ChatOrder::PAYMENT_PAYME;
                                    if ($type == "click")
                                        $order->payment_type = ChatOrder::PAYMENT_CLICK;

                                    // check delivery type
                                    $delivery = 0;
                                    if (!$order->isPickUp())
                                        $delivery = (float) Setting::get("delivery_price");

                                    $order->delivery_price = $delivery;
                                    $order->save();

                                    // start invoice
                                    $invoice_payload = $type . ':' . $order->id;

                                    $details = ChatOrderDetail::where([
                                        "chat_order_id" => $order->id
                                    ])->get();

                                    if (!empty($details)) {

                                        $title = "BookMarket24.uz";
                                        $desc = "Мы всегда стараемся быть лучшими";
                                        $image_url = "";
                                        $total = 0;
                                        $prices = [];
                                        $delivery = $delivery * 100;

                                        foreach($details as $detail) {
                                            if (!is_null($detail->product->image)) {
                                                $thumbnail = $detail->product->image->getImageUrl("1080x1080");
                                                $image_url = "https://".$request->getHttpHost() . "" . $thumbnail;
                                            }
                                            $prices[] = [
                                                'label' => $title,
                                                'amount' => (float) ($detail->price * $detail->quantity) * 100
                                            ];
                                            $total += $detail->price * $detail->quantity;
                                        }
                                        $prices[] = [
                                            'label' => "Доставка",
                                            'amount' => $delivery
                                        ];

                                        $invoice = [];
                                        $invoice['chat_id'] = $chat_id;
                                        $invoice['title'] = $title;
                                        $invoice['description'] = $desc;
                                        $invoice['is_flexible'] = false;
                                        $invoice['payload'] = $invoice_payload;
                                        $invoice['photo_url'] = $image_url;
                                        $invoice['photo_width'] = 500;
                                        $invoice['photo_height'] = 500;
                                        $invoice['provider_token'] = $bot_token;
                                        $invoice['currency'] = 'UZS';
                                        $invoice['prices'] = $prices;
                                        $invoice['provider_data'] = json_encode($prices);
                                        $invoice['start_parameter'] = "bookmarket24_payment";
                                        // $invoice['need_name'] = true;
                                        // $invoice['need_phone_number'] = true;

                                        try {
                                            $response = Telegram::sendInvoice($invoice);
                                            $order->amount = $total;
                                            $order->save();
                                        } catch (Exception $e) {
                                            TelegramLog::log($e->getMessage());
                                        }
                                    } else {
                                        TelegramLog::log("Chat Order Detail is not found: " . $chat_id);
                                    }
                                } else {
                                    TelegramLog::log("Chat Order is not found: " . $chat_id);
                                }
                            } catch (Exception $e) {
                                TelegramLog::log($e->getMessage());
                            }
                        }
                    } else if (isset($decode->home) || (isset($decode->back) && $decode->back == 0) || isset($decode->clear)) {

                        // clear all data
                        if (isset($decode->clear)) {
                            $order = ChatOrder::where([
                                "chat_id" => $chat_id,
                                "state" => ChatOrder::STATE_DRAF
                            ])->first();
                            if (!is_null($order)) {
                                $order->delete();
                                $order->deleteDetails();
                            }
                        }

                        $text = Lang::get("bot.select_category");
                        $categories = Category::where([
                            'status' => Category::STATUS_ACTIVE,
                            'deleted' => Category::NO_DELETED
                        ])->orderBy('order_no')->get();

                        try {
                            $reply_markup = BotKeyboard::categories($categories);

                            // edit message reply markup
                            Telegram::sendMessage([
                                "chat_id" => $chat_id,
                                "text" => $text,
                                "parse_mode" => "Markdown",
                                "reply_markup" => $reply_markup
                            ]);

                        } catch (Exception $e) {
                            TelegramLog::log($e->getMessage());
                        }

                        try {
                            if (isset($decode->home) || isset($decode->clear)) {
                                // edit message reply markup
                                Telegram::editMessageReplyMarkup([
                                    'chat_id' => $chat_id,
                                    'message_id' => $message_id,
                                    'inline_message_id' => $message_id,
                                    // 'caption' => $caption,
                                    'parse_mode' => "Markdown",
                                    'reply_markup' => false
                                ]);
                            } else if ($decode->back == 0) {
                                // delete message
                                Telegram::deleteMessage([
                                    'chat_id' => $chat_id,
                                    'message_id' => $message_id
                                ]);
                            }
                        } catch (Exception $e) {
                            TelegramLog::log($e->getMessage());
                        }
                    } else if (isset($decode->cat) || (isset($decode->back) && $decode->back == 4)) {

                        $text = Lang::get("bot.select_product");
                        $products = Product::where([
                            'status' => Product::STATUS_ACTIVE,
                            'deleted' => Product::NO_DELETED,
                            'category_id' => $decode->cat,
                        ])->get();

                        try {
                            $reply_markup = BotKeyboard::products($products, 0);

                            // edit message reply markup
                            Telegram::sendMessage([
                                "chat_id" => $chat_id,
                                "text" => $text,
                                "parse_mode" => "Markdown",
                                "reply_markup" => $reply_markup
                            ]);

                        } catch (Exception $e) {
                            TelegramLog::log($e->getMessage());
                        }

                        try {
                            // delete message
                            Telegram::deleteMessage([
                                'chat_id' => $chat_id,
                                'message_id' => $message_id
                            ]);
                        } catch (Exception $e) {
                            TelegramLog::log($e->getMessage());
                        }
                    } else if (isset($decode->ch)) {
                        $product_id = $decode->pro;
                        $number = intval($decode->num);
                        $product = Product::find($product_id);
                        $book = Book::find($decode->b_id);

                        $text = "*".Lang::get('bot.name').":* ".$product->translateorNew($locale)->name."\n\n";
                        // $text .= "*".Lang::get('bot.description').":* " . $product->description . "\n\n";
                        $text = $book->getDescription($text, $locale);
                        // make enter
                        $text .= "\n";
                        $text .= "*".Lang::get('bot.price').":* ".GlobalFunc::moneyFormat($book->getPrice());
                        try {
                            $reply_markup = BotKeyboard::product($product_id, $number, $locale, $book);
                            if (!is_null($product->image)) {
                                // edit message caption
                                Telegram::editMessageCaption([
                                    'chat_id' => $chat_id,
                                    'message_id' => $message_id,
                                    'caption' => $text,
                                    'parse_mode' => "Markdown",
                                    'reply_markup' => $reply_markup
                                ]);
                            } else {
                                // edit message text
                                Telegram::editMessageText([
                                    'chat_id' => $chat_id,
                                    'message_id' => $message_id,
                                    'text' => $text,
                                    'parse_mode' => "Markdown",
                                    'reply_markup' => $reply_markup
                                ]);
                            }
                        } catch (Exception $e) {
                            TelegramLog::log($e->getMessage());
                        }
                    } else if (isset($decode->pro)) {
                        $product = Product::find($decode->pro);

                        if (!is_null($product)) {
                            $number = 1;
                            $thumbnail = "/public/images/no_image.jpg";
                            if (!is_null($product->image)) {
                                $thumbnail = $product->image->getImageUrl("1080x1080");
                                $url = "https://".$request->getHttpHost() . "" . $thumbnail;
                                // make caption
                                $caption = "*".Lang::get('bot.name').":* ".$product->translateorNew($locale)->name."\n\n";
                                // $caption .= "*".Lang::get('bot.description').":* " . $product->description . "\n\n";
                                $book = $product->book();
                                $caption = $book->getDescription($caption, $locale);
                                // make enter
                                $caption .= "\n";
                                // price
                                $caption .= "*".Lang::get('bot.price').":* ". GlobalFunc::moneyFormat($book->getPrice());

                                try {
                                    $reply_markup = BotKeyboard::product($product->id, $number, $locale);
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
                                $text = "*".Lang::get('bot.name').":* ".$product->translateorNew($locale)->name."\n\n";
                                // $text .= "*".Lang::get('bot.description').":* " . $product->description . "\n\n";
                                $book = $product->book();
                                $text = $book->getDescription($text, $locale);
                                // make enter
                                $text .= "\n";
                                // price
                                $text .= "*".Lang::get('bot.price').":* ".GlobalFunc::moneyFormat($book->getPrice());

                                try {
                                    $reply_markup = BotKeyboard::product($product->id, $number, $locale);
                                    // send message
                                    Telegram::sendMessage([
                                        'chat_id' => $chat_id,
                                        'text' => $text,
                                        'parse_mode' => "Markdown",
                                        'reply_markup' => $reply_markup
                                    ]);
                                } catch (Exception $e) {
                                    TelegramLog::log($e->getMessage());
                                }
                            }

                            try {
                                // delete message
                                Telegram::deleteMessage([
                                    'chat_id' => $chat_id,
                                    'message_id' => $message_id
                                ]);
                            } catch (Exception $e) {
                                TelegramLog::log($e->getMessage());
                            }
                        } else {
                            TelegramLog::log("Product is not found: " . $decode->pro);
                        }
                    } else if (isset($decode->order)) {
                        // try {
                        //     $reply_markup = BotKeyboard::delivery(3);
                        //     // edit message reply markup
                        //     Telegram::editMessageReplyMarkup([
                        //         'chat_id' => $chat_id,
                        //         'message_id' => $message_id,
                        //         'inline_message_id' => $message_id,
                        //         'parse_mode' => "Markdown",
                        //         'reply_markup' => $reply_markup
                        //     ]);
                        // } catch (Exception $e) {
                        //     TelegramLog::log($e->getMessage());
                        // }

                        // get chat order
                        $order = ChatOrder::where([
                            "chat_id" => $chat_id,
                            "state" => ChatOrder::STATE_DRAF
                        ])->first();

                        if (!is_null($order)) {
                            $order->delivery_type = ChatOrder::DELIVERY_DELIVERY;
                            if ($order->save()) {
                                // get last order
                                $lastOrder = GlobalFunc::getLastOrder($chat_id);
                                $text = Lang::get("bot.send_location");
                                // update step
                                if (!is_null($chatUser)) {
                                    $chatUser->step = Step::LAST_ORDER;
                                    $chatUser->save();
                                }
                                try {
                                    $reply_markup = BotKeyboard::location($lastOrder);
                                    // edit message reply markup
                                    Telegram::sendMessage([
                                        "chat_id" => $chat_id,
                                        "text" => $text,
                                        "reply_markup" => $reply_markup
                                    ]);

                                } catch (Exception $e) {
                                    TelegramLog::log($e->getMessage());
                                }
                                // edit message reply markup
                                try {
                                    Telegram::editMessageReplyMarkup([
                                        'chat_id' => $chat_id,
                                        'message_id' => $message_id,
                                        'inline_message_id' => $message_id,
                                        'parse_mode' => "HTML",
                                        'reply_markup' => false
                                    ]);
                                } catch (Exception $e) {
                                    TelegramLog::log($e->getMessage());
                                }
                            }

                        } else {
                            TelegramLog::log("Order is not found: chat_id = " . $chat_id);
                        }
                    } else if (isset($decode->back) && $decode->back == 7) {
                        // agar nastroykada bermagan bo'lsa, ya'ni
                        // zakaz tushmagan bo'lsa avval tel nomer jo'natishi kerak
                        $customer = $chatUser->customer();
                        if (!$chatUser->existCustomer() || is_null($customer)) {
                            $text = Lang::get("bot.send_phone");
                            try {
                                $reply_markup = BotKeyboard::contact();
                                // edit message reply markup
                                Telegram::sendMessage([
                                    "chat_id" => $chat_id,
                                    "text" => $text,
                                    "parse_mode" => "Markdown",
                                    "reply_markup" => $reply_markup
                                ]);

                            } catch (Exception $e) {
                                TelegramLog::log($e->getMessage());
                            }
                            // edit message reply markup
                            try {
                                Telegram::editMessageReplyMarkup([
                                    'chat_id' => $chat_id,
                                    'message_id' => $message_id,
                                    'inline_message_id' => $message_id,
                                    'reply_markup' => false
                                ]);
                            } catch (Exception $e) {
                                TelegramLog::log($e->getMessage());
                            }
                        } else if (!is_null($customer)) {
                            // get last order
                            $lastOrder = GlobalFunc::getLastOrder($chat_id);
                            $text = Lang::get("bot.send_location");
                            // update step
                            $chatUser->step = Step::LAST_ORDER;
                            $chatUser->save();
                            try {
                                $reply_markup = BotKeyboard::location($lastOrder);
                                // edit message reply markup
                                Telegram::sendMessage([
                                    "chat_id" => $chat_id,
                                    "text" => $text,
                                    "reply_markup" => $reply_markup
                                ]);

                            } catch (Exception $e) {
                                TelegramLog::log($e->getMessage());
                            }
                        }
                    } else if (isset($decode->lang)) {

                        $locale = $decode->lang;
                        $chatUser = ChatUser::where('chat_id', $chat_id)->first();
                        if (is_null($chatUser)) {
                            $attributes['chat_id'] = $from->getId();
                            $attributes['first_name'] = $from->getFirstName();
                            $attributes['last_name'] = $from->getLastName();
                            $attributes['username'] = $from->getUsername();
                            $attributes['language_code'] = $from->getLanguageCode();
                            $attributes['locale'] = $locale;
                            $chatUser = ChatUser::create($attributes);
                        } else {
                            $chatUser->locale = $locale;
                            $chatUser->save();
                        }
                        //set language
                        App::setLocale($locale);

                        $text = Lang::get("bot.select_category");
                        $categories = Category::where([
                            'status' => Category::STATUS_ACTIVE,
                            'deleted' => Category::NO_DELETED
                        ])->orderBy('order_no')->get();

                        try {
                            $reply_markup = BotKeyboard::categories($categories);
                            // send message reply markup
                            Telegram::editMessageText([
                                "chat_id" => $chat_id,
                                "message_id" => $message_id,
                                "text" => $text,
                                "parse_mode" => "Markdown",
                                "reply_markup" => $reply_markup
                            ]);
                        } catch (Exception $e) {
                            TelegramLog::log($e->getMessage());
                        }
                    } else if (isset($decode->setting) || (isset($decode->back) && $decode->back == 10)) {
                        if (!is_null($chatUser)) {
                            // update step
                            $chatUser->step = Step::SETTING;
                            $chatUser->save();
                        }
                        $text = Lang::get("bot.setting_text");
                        try {
                            $reply_markup = BotKeyboard::settings();
                            // edit message reply markup
                            Telegram::editMessageText([
                                "chat_id" => $chat_id,
                                "message_id" => $message_id,
                                "text" => $text,
                                "parse_mode" => "Markdown",
                                "reply_markup" => $reply_markup
                            ]);
                        } catch (Exception $e) {
                            TelegramLog::log($e->getMessage());
                        }
                    } else if (isset($decode->langs)) {
                        $text = Lang::get("bot.change_language_text");
                        try {
                            $reply_markup = BotKeyboard::changeLang($locale);
                            // edit message reply markup
                            Telegram::editMessageText([
                                "chat_id" => $chat_id,
                                "message_id" => $message_id,
                                "text" => $text,
                                "parse_mode" => "Markdown",
                                "reply_markup" => $reply_markup
                            ]);
                        } catch (Exception $e) {
                            TelegramLog::log($e->getMessage());
                        }
                    } else if (isset($decode->phone) || isset($decode->chan_ph)) {
                        if (!is_null($chatUser)) {
                            $customer = Customer::where([
                                'customer_type' => Customer::TYPE_TELEGRAM,
                                'uid' => $chat_id
                            ])->first();
                            if (is_null($customer) || isset($decode->chan_ph)) {
                                // update step
                                $chatUser->step = Step::CHANGE_PHONE;
                                $chatUser->save();
                                // send contact
                                $text = Lang::get("bot.send_customer_phone");
                                try {
                                    $reply_markup = BotKeyboard::addContact();
                                    Telegram::sendMessage([
                                        "chat_id" => $chat_id,
                                        "text" => $text,
                                        "parse_mode" => "Markdown",
                                        "reply_markup" => $reply_markup
                                    ]);
                                } catch (Exception $e) {
                                    TelegramLog::log($e->getMessage());
                                }
                                // edit message reply markup
                                try {
                                    Telegram::editMessageReplyMarkup([
                                        'chat_id' => $chat_id,
                                        'message_id' => $message_id,
                                        'inline_message_id' => $message_id,
                                        'parse_mode' => "HTML",
                                        'reply_markup' => false
                                    ]);
                                } catch (Exception $e) {
                                    TelegramLog::log($e->getMessage());
                                }
                            } else {
                                $text = Lang::get("bot.change_customer_phone", ["phone" => "+".$customer->phone_number]);
                                try {
                                    $reply_markup = BotKeyboard::changeContact($customer->phone_number);
                                    Telegram::editMessageText([
                                        "chat_id" => $chat_id,
                                        "message_id" => $message_id,
                                        "text" => $text,
                                        "parse_mode" => "Markdown",
                                        "reply_markup" => $reply_markup
                                    ]);
                                } catch (Exception $e) {
                                    TelegramLog::log($e->getMessage());
                                }
                            }
                        }
                    } else if (isset($decode->num)) {
                        $message = $decode->num . " 👍";
                        try {
                            $params = BotKeyboard::alert($callback, $message);
                            Telegram::answerCallbackQuery($params);
                        } catch (Exception $e) {
                            TelegramLog::log($e->getMessage());
                        }
                    }
                } else if (!is_null($chat) && in_array(strtolower($chat->getType()), ["group", "supergroup"])) {

                    $chat_id = $chat->getId();
                    $decode = json_decode($data);
                    // TelegramLog::log($decode);

                    if (isset($decode->o)) {
                        $order = ChatOrder::find($decode->o);
                        if (!is_null($order)) {
                            // make paid client, or not
                            if (isset($decode->paid)) {
                                $order->paid = $decode->paid;
                                if ($order->save()) {
                                    if ($order->isPaid()) {
                                        $locale = "ru";
                                        $chatUser = ChatUser::where('chat_id', $order->chat_id)->first();
                                        if (!is_null($chatUser))
                                            $locale = $chatUser->locale;
                                        App::setLocale($locale);
                                        $text = Lang::get('bot.thank_you_your_order_accepted') ." <b>". $order->id ."</b>";
                                        try {
                                            $keyboard = BotKeyboard::home();
                                            // edit message text
                                            Telegram::editMessageText([
                                                'chat_id' => $order->chat_id,
                                                'text' => $text,
                                                'parse_mode' => "HTML",
                                                'message_id' => $order->message_id,
                                                'reply_markup' => $keyboard
                                            ]);
                                        } catch (Exception $e) {
                                            TelegramLog::log($e->getMessage());
                                        }
                                    }
                                }
                            } else if (isset($decode->del)) {
                                $order->state = $decode->del;
                                $order->save();

                                // send client message for process
                                if (GlobalFunc::sendableState($order->state)) {
                                    $text = Lang::get('bot.client_notification_for_state', [
                                        'code' => $order->id,
                                        'state' => $order->stateLabel()
                                    ]);
                                    try {
                                        $response = Telegram::sendMessage([
                                            'chat_id' => $order->chat_id,
                                            'text' => $text,
                                            'parse_mode' => "Markdown",
                                        ]);
                                    } catch (Exception $e) {
                                        TelegramLog::log($e->getMessage());
                                    }
                                }
                            }

                            // change group
                            $locale = env('LANG_DEFAULT') || "ru";
                            App::setLocale($locale);
                            $text = $order->telegramOrderList();
                            $keyboard = BotKeyboard::status($order);

                            try {
                                $response = Telegram::editMessageText([
                                    'chat_id' => $chat_id,
                                    'message_id' => $message_id,
                                    'text' => $text,
                                    'parse_mode' => "HTML",
                                    'reply_markup' => $keyboard,
                                ]);
                            } catch (Exception $e) {
                                TelegramLog::log($e->getMessage());
                            }
                        }
                    }
                }
            }

        } else if (!is_null($message) && !$message->isEmpty()) {

            $command = $message->getText();
            $chat = $message->getChat();
            $from = $message->getFrom();
            $sender_chat = $message->getSenderChat();
            $contact = $message->getContact();
            $location = $message->getLocation();
            $message_id = $message->getMessageId();
            $new_member = $message->getNewChatParticipant();
            $left_member = $message->getLeftChatParticipant();
            $success_payment = $message->getSuccessfulPayment();

            if (!is_null($chat)) {
                $chat_id = $chat->getId();
                $type = $chat->getType();
                $title = $chat->getTitle(); // this username for channel
                $all_admin = 1; //

                // TelegramLog::log($response);

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
                                $fullname = $from->getFirstName();
                                if (!empty($from->getLastName()))
                                    $fullname = $fullname . " " . $from->getLastName();

                                try {
                                    // create new
                                    $model = ChatGroup::create([
                                        'chat_id' => $chat_id,
                                        'title' => $title,
                                        'all_admin' => $all_admin,
                                        'from_id' => $from_id,
                                        'type' => $type
                                    ]);

                                    if (!is_null($model)) {
                                        try {
                                            $group_id = Setting::get('order_group');
                                            $text = 'This ['. $username . '](http://t.me/'.$username.') bot just added new '. $type .' (*'.$title.'*) by '.$fullname;

                                            Telegram::sendMessage([
                                                'chat_id' => $group_id,
                                                'text' => $text,
                                                'parse_mode' => "Markdown"
                                            ]);
                                        } catch (Exception $e) {
                                            TelegramLog::log($e->getMessage());
                                        }
                                    }

                                    $text = Lang::get("bot.thanks", ['fullname' => $fullname]);

                                    // send message
                                    Telegram::sendMessage([
                                        'chat_id' => $chat_id,
                                        'text' => $text,
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

                    if (strtolower($command) == "/chat_id"  ||  strtolower($command) == "/chatid") {
                        try {
                            $text = "This is your group chat ID: *".$chat_id."*";
                            Telegram::sendMessage([
                                'chat_id' => $chat_id,
                                'text' => $text,
                                'parse_mode' => "Markdown"
                            ]);
                        } catch (Exception $e) {
                            TelegramLog::log($e->getMessage());
                        }
                    }

                } else if ($type == "channel") {

                    // save channel ID
                    $chatGroup = ChatGroup::where(['chat_id' => $chat_id])->first();

                    if (is_null($chatGroup)) {
                        try {
                            // create new
                            $model = ChatGroup::create([
                                'chat_id' => $chat_id,
                                'title' => $title,
                                'all_admin' => $all_admin,
                                'type' => $type
                            ]);

                            if (!is_null($model)) {
                                try {
                                    $fullname = "admin";
                                    $username = env("TELEGRAM_BOT_USERNAME");
                                    $group_id = Setting::get('order_group');
                                    $text = 'This ['. $username . '](http://t.me/'.$username.') bot just added new '. $type .' (*'.$title.'*) by '.$fullname;

                                    Telegram::sendMessage([
                                        'chat_id' => $group_id,
                                        'text' => $text,
                                        'parse_mode' => "Markdown"
                                    ]);

                                } catch (Exception $e) {
                                    TelegramLog::log($e->getMessage());
                                }
                            }

                        } catch (Exception $e) {
                            TelegramLog::log($e->getMessage());
                        }
                    }

                } else if ($type == "private") {

                    // set russion language
                    $locale = "ru";
                    $chatUser = ChatUser::where('chat_id', $chat_id)->first();
                    if (!is_null($chatUser)) {
                        $locale = $chatUser->locale;
                    } else {
                        GlobalFunc::createChatUser($chat);
                    }
                    App::setLocale($locale);

                    // check payment is successful
                    if (!is_null($success_payment)) {
                        $order = ChatOrder::where([
                            "chat_id" => $chat_id,
                            "state" => ChatOrder::STATE_DRAF
                        ])->first();

                        if (!is_null($order)) {
                            $order->paid = ChatOrder::PAID_SUCCESS;
                            $order->state = ChatOrder::STATE_NEW;
                            if ($order->save()) {

                                try {
                                    // edit message reply markup
                                    Telegram::editMessageReplyMarkup([
                                        'chat_id' => $chat_id,
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

                                // create order
                                // $order->createOrder($chatUser);

                                // ~~~~~~~~~~~~~~~~~ send group check

                                // set default language
                                $locale = env('LANG_DEFAULT') || "ru";
                                App::setLocale($locale);
                                $group_id = Setting::get('order_group');
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
                            }
                        }
                    } else if (strpos($command, "product") !== false) {

                        $str = explode("-", $command);
                        $product_id = $str[1];
                        $product = Product::find($product_id);

                        if (!is_null($product)) {
                            $post = ChatPost::where(['product_id' => $product->id])
                                ->orderByDesc("created_at")->first();
                            $thumbnail = $product->image->getImageUrl("1080x1080");
                            $url = "https://".$request->getHttpHost() . "" . $thumbnail;
                            $caption = $post->caption;
                            try {
                                $reply_markup = BotKeyboard::product($product->id, 1, $locale);
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
                    } else if (preg_match("/^[0-9]{4}$/", $command)) {
                        // get code
                        $code = (int) $command;
                        if ($code > 0) {
                            // check code
                            $order = ChatOrder::where([
                                "chat_id" => $chat_id,
                                "state" => ChatOrder::STATE_DRAF
                            ])->first();
                            if (!is_null($order)) {

                                if ($code == $order->code) {
                                    // update step
                                    if (!is_null($chatUser)) {
                                        $chatUser->step = Step::CHECK_LIST;
                                        $chatUser->save();
                                    }

                                    // check delivery type
                                    $delivery = 0;
                                    if (!$order->isPickUp())
                                        $delivery = (float) Setting::get("delivery_price");

                                    $text = Lang::get("bot.your_order");

                                    $total = 0;
                                    $total_with_delivery = $delivery;
                                    foreach($order->details as $index => $detail) {
                                        $amount = $detail->price * $detail->quantity;
                                        $text .= ($index+1) .". <b>". $detail->product->translateorNew($locale)->name ." (";
                                        if (!is_null($detail->book))
                                            $text .= $detail->book->getBtnLabel($locale) .")</b>\n";
                                        $text .= "✏️   <i>" . GlobalFunc::moneyFormat($detail->price, false) ."</i> x "
                                        . $detail->quantity ." = <i>";
                                        $text .= GlobalFunc::moneyFormat($amount)."</i>\n";
                                        // calculate total
                                        $total += $amount;
                                        $total_with_delivery += $amount;
                                    }

                                    $text .= "\n";
                                    $text .= Lang::get("bot.amount")." <i>" . GlobalFunc::moneyFormat($total) . "</i>\n";
                                    $text .= Lang::get("bot.delivery") ." <i>" . GlobalFunc::moneyFormat($delivery)
                                    . "</i> " . Lang::get("bot.in_tashkent");
                                    $text .= Lang::get("bot.total") . " <i>" . GlobalFunc::moneyFormat($total_with_delivery) ."</i>";

                                    try {
                                        // main keyboard
                                        $reply_markup = BotKeyboard::main();
                                        Telegram::sendMessage([
                                            'chat_id' => $chat_id,
                                            'text' => Lang::get("bot.success_code"),
                                            'reply_markup' => $reply_markup
                                        ]);

                                        // send message
                                        $reply_markup = BotKeyboard::totalCheck($total_with_delivery, $order);
                                        $response = Telegram::sendMessage([
                                            'chat_id' => $chat_id,
                                            'text' => $text,
                                            'parse_mode' => "HTML",
                                            'reply_markup' => $reply_markup
                                        ]);

                                        // save total and delivery price
                                        $order->amount = $total;
                                        $order->delivery_price = $delivery;
                                        // save message ID, after successful payment remove inline keyboard
                                        $order->message_id = $response->getMessageId();
                                        $order->save();

                                    } catch (Exception $e) {
                                        TelegramLog::log($e->getMessage());
                                    }

                                } else {
                                    $text = Lang::get("bot.no_correct_code");
                                    try {
                                        Telegram::sendMessage([
                                            "chat_id" => $chat_id,
                                            "text" => $text,
                                            "parse_mode" => "Markdown"
                                        ]);

                                    } catch (Exception $e) {
                                        TelegramLog::log($e->getMessage());
                                    }
                                }
                            }

                        } else {

                            $text = Lang::get("bot.not_format_code");
                            try {
                                Telegram::sendMessage([
                                    "chat_id" => $chat_id,
                                    "text" => $text,
                                    "parse_mode" => "Markdown"
                                ]);
                            } catch (Exception $e) {
                                TelegramLog::log($e->getMessage());
                            }
                        }

                    } else if (strpos($command, "⏱") !== false) {

                        $order = ChatOrder::where([
                            "chat_id" => $chat_id,
                            "state" => ChatOrder::STATE_DRAF
                        ])->first();
                        if (!is_null($order)) {

                            // reset code
                            $order->code = rand(1000, 9999);
                            if ($order->save()) {

                                // send sms for client
                                $txt = "Tasdiqlash kodi
                                Confirmation code: " . $order->code;
                                Sms::send($order->phone, $txt);

                                // send code
                                $text = Lang::get("bot.resend_code");

                                try {
                                    $reply_markup = BotKeyboard::check_code();

                                    Telegram::sendMessage([
                                        "chat_id" => $chat_id,
                                        "text" => $text,
                                        "parse_mode" => "Markdown",
                                        "reply_markup" => $reply_markup
                                    ]);

                                } catch (Exception $e) {
                                    TelegramLog::log($e->getMessage());
                                }

                            }
                        }

                    // if phone number format
                    } else if (preg_match("/^[0-9]{9}$/", $command)) {
                        // get phone
                        $phone = $command;
                        // save contact
                        $order = ChatOrder::where([
                            "chat_id" => $chat_id,
                            "state" => ChatOrder::STATE_DRAF
                        ])->first();
                        if (!is_null($order)) {

                            $order->phone = "998" . $phone;
                            if ($order->save()) {
                                // create customer
                                try {
                                    if (!$chatUser->existCustomer()) {
                                        $customer = Customer::create([
                                            'uid' => $chat_id,
                                            'phone_number' => $order->phone,
                                            'status' => Customer::STATUS_ACTIVE,
                                            'customer_type' => Customer::TYPE_TELEGRAM
                                        ]);
                                        if (!is_null($customer)) {
                                            $chatUser->customer_id = $customer->id;
                                            $chatUser->save();
                                        }
                                    }
                                } catch (\Throwable $th) {
                                    TelegramLog::log($th->getMessage());
                                }
                                // check order already exists
                                $old_order_count = ChatOrder::where([
                                    [ "chat_id", "=", $chat_id ],
                                    [ "state", "!=", ChatOrder::STATE_DRAF ]
                                ])->count();

                                if ($old_order_count > 0) {
                                    // update step
                                    $chatUser->step = Step::CHECK_LIST;
                                    $chatUser->save();

                                    // check delivery type
                                    $delivery = 0;
                                    if (!$order->isPickUp())
                                        $delivery = (float) Setting::get("delivery_price");

                                    $text = Lang::get("bot.your_order");

                                    $total = 0;
                                    $total_with_delivery = $delivery;
                                    foreach($order->details as $index => $detail) {
                                        $amount = $detail->price * $detail->quantity;
                                        $text .= ($index+1) .". <b>". $detail->product->translateorNew($locale)->name ." (";
                                        if (!is_null($detail->book))
                                            $text .= $detail->book->getBtnLabel($locale) .")</b>\n";
                                        $text .= "✏️   <i>" . GlobalFunc::moneyFormat($detail->price, false) ."</i> x "
                                        . $detail->quantity ." = <i>";
                                        $text .= GlobalFunc::moneyFormat($amount)."</i>\n";
                                        // calculate total
                                        $total += $amount;
                                        $total_with_delivery += $amount;
                                    }

                                    $text .= "\n";
                                    $text .= Lang::get("bot.amount")." <i>" . GlobalFunc::moneyFormat($total) . "</i>\n";
                                    $text .= Lang::get("bot.delivery") ." <i>" . GlobalFunc::moneyFormat($delivery)
                                    . "</i> " . Lang::get("bot.in_tashkent");
                                    $text .= Lang::get("bot.total") . " <i>" . GlobalFunc::moneyFormat($total_with_delivery) ."</i>";

                                    try {

                                        // hide keyboard
                                        $reply_markup = BotKeyboard::hideKeyboard();

                                        Telegram::sendMessage([
                                            'chat_id' => $chat_id,
                                            'text' => Lang::get("bot.success_code"),
                                            'reply_markup' => $reply_markup
                                        ]);

                                        // send message
                                        $reply_markup = BotKeyboard::totalCheck($total_with_delivery, $order);

                                        $response = Telegram::sendMessage([
                                            'chat_id' => $chat_id,
                                            'text' => $text,
                                            'parse_mode' => "HTML",
                                            'reply_markup' => $reply_markup
                                        ]);

                                        // save total and delivery price
                                        $order->amount = $total;
                                        $order->delivery_price = $delivery;
                                        // save message ID, after successful payment remove inline keyboard
                                        $order->message_id = $response->getMessageId();
                                        $order->save();

                                    } catch (Exception $e) {
                                        TelegramLog::log($e->getMessage());
                                    }

                                } else {

                                    $order->code = rand(1000, 9999);
                                    if ($order->save()) {

                                        // send sms for client
                                        $txt = "Tasdiqlash kodi
                                        Confirmation code: " . $order->code;
                                        Sms::send($order->phone, $txt);

                                        // send code
                                        $text = Lang::get("bot.send_code");

                                        try {
                                            $reply_markup = BotKeyboard::check_code();

                                            Telegram::sendMessage([
                                                "chat_id" => $chat_id,
                                                "text" => $text,
                                                "reply_markup" => $reply_markup
                                            ]);

                                        } catch (Exception $e) {
                                            TelegramLog::log($e->getMessage());
                                        }

                                    }
                                }

                            }

                        }
                    } else if (ctype_digit($command) && strlen($command) > 5) {

                        // send phone number error
                        $text = Lang::get("bot.no_correct_phone");
                        try {
                            Telegram::sendMessage([
                                "chat_id" => $chat_id,
                                "text" => $text,
                                "parse_mode" => "Markdown"
                            ]);
                        } catch (Exception $e) {
                            TelegramLog::log($e->getMessage());
                        }

                    } else if ($command == "/start") {

                        $text = "🙏 Assalomu aleykum, Bu bot orqali siz juda qiziq va ko'p kitoblarni arzon narxlarda sotib olishingiz mumkin\n\n🙏 Ассаламу алейкум, этот бот поможет вам купить много интересных книг и дешовый кника можна купить\n\n🙏 Assalomu aleykum, this bot will help you buy a lot of interesting books and you can buy a cheap book";
                        try {
                            $reply_markup = BotKeyboard::main();
                            // send message reply markup
                            Telegram::sendMessage([
                                "chat_id" => $chat_id,
                                "text" => $text,
                                "parse_mode" => "Markdown",
                                "reply_markup" => $reply_markup
                            ]);
                        } catch (Exception $e) {
                            TelegramLog::log($e->getMessage());
                        }

                        $text = Lang::get("bot.select_language");
                        try {
                            $reply_markup = BotKeyboard::welcome();
                            // send message reply markup
                            Telegram::sendMessage([
                                "chat_id" => $chat_id,
                                "text" => $text,
                                "parse_mode" => "Markdown",
                                "reply_markup" => $reply_markup
                            ]);
                        } catch (Exception $e) {
                            TelegramLog::log($e->getMessage());
                        }
                    } else if (strpos($command, "🛒") !== false) {

                        // remove cart keyboard
                        try {
                            $reply_markup = BotKeyboard::hideKeyboard();
                            Telegram::sendMessage([
                                "chat_id" => $chat_id,
                                "text" => Lang::get('bot.btn_back'),
                                "parse_mode" => "Markdown",
                                "reply_markup" => $reply_markup
                            ]);
                        } catch (Throwable $th) {
                            TelegramLog::log($th->getMessage());
                        }

                        // check already exists
                        $order = ChatOrder::where([
                            "chat_id" => $chat_id,
                            "state" => ChatOrder::STATE_DRAF
                        ])->first();

                        if (is_null($order)) {
                            // home page
                            $text = Lang::get("bot.select_category");
                            $categories = Category::where([
                                'status' => Category::STATUS_ACTIVE,
                                'deleted' => Category::NO_DELETED
                            ])->orderBy('order_no')->get();

                            try {
                                $reply_markup = BotKeyboard::categories($categories);
                                // edit message reply markup
                                Telegram::sendMessage([
                                    "chat_id" => $chat_id,
                                    "text" => $text,
                                    "parse_mode" => "Markdown",
                                    "reply_markup" => $reply_markup
                                ]);
                            } catch (Exception $e) {
                                TelegramLog::log($e->getMessage());
                            }
                        } else {
                            // cart list
                            try {
                                $total = 0;
                                $details = $order->details;
                                $text = Lang::get("bot.your_cart");
                                foreach($details as $index => $detail) {
                                    $amount = $detail->price * $detail->quantity;
                                    $text .= ($index+1) .". <b>". $detail->product->translateorNew($locale)->name ." (";
                                    if (!is_null($detail->book))
                                        $text .= $detail->book->getBtnLabel($locale) .")</b>\n";
                                    $text .= "✏️   <i>" . GlobalFunc::moneyFormat($detail->price, false) ."</i> x "
                                    . $detail->quantity ." = <i>";
                                    $text .= GlobalFunc::moneyFormat($amount)."</i>\n";
                                    $total += $amount;
                                }
                                $text .= "\n".Lang::get('bot.total')." ".GlobalFunc::moneyFormat($total);
                                $reply_markup = BotKeyboard::cart($details, 2);
                                // edit message reply markup
                                Telegram::sendMessage([
                                    "chat_id" => $chat_id,
                                    "text" => $text,
                                    "parse_mode" => "HTML",
                                    "reply_markup" => $reply_markup
                                ]);

                            } catch (Exception $e) {
                                TelegramLog::log($e->getMessage());
                            }
                        }

                    } else if (strpos($command, "🏠") !== false) {
                        $text = Lang::get("bot.select_category");
                        $categories = Category::where([
                            'status' => Category::STATUS_ACTIVE,
                            'deleted' => Category::NO_DELETED
                        ])->orderBy('order_no')->get();

                        try {
                            $reply_markup = BotKeyboard::categories($categories);
                            // send message reply markup
                            Telegram::sendMessage([
                                "chat_id" => $chat_id,
                                "text" => $text,
                                "parse_mode" => "Markdown",
                                "reply_markup" => $reply_markup
                            ]);
                        } catch (Exception $e) {
                            TelegramLog::log($e->getMessage());
                        }
                    } else if (!is_null($chatUser) && $chatUser->step == Step::LAST_ORDER) {
                        $lastOrder = GlobalFunc::getLastOrder($chat_id);
                        if (!is_null($lastOrder)) {
                            $order = ChatOrder::where([
                                "chat_id" => $chat_id,
                                "state" => ChatOrder::STATE_DRAF
                            ])->first();
                            if (!is_null($order)) {
                                $order->lat = $lastOrder->lat;
                                $order->long = $lastOrder->long;
                                if ($order->save()) {
                                    // update step
                                    $chatUser->step = Step::LOCATION;
                                    $chatUser->save();
                                    // save distance
                                    $shop_lat = Setting::get('shop_lat');
                                    $shop_lng = Setting::get('shop_lng');
                                    $distance = null;
                                    if (!empty($shop_lat) && !empty($shop_lng)) {
                                        $distance = GlobalFunc::haversineGreatCircleDistance($shop_lat, $shop_lng, $order->lat, $order->long);
                                        if (!is_null($distance) && $distance > 0) {
                                            $order->distance = $distance;
                                            $order->save();
                                        }
                                    }
                                }

                                // agar nastroykada bermagan bo'lsa, ya'ni
                                // zakaz tushmagan bo'lsa avval tel nomer jo'natishi kerak
                                $customer = $chatUser->customer();
                                if (!$chatUser->existCustomer() || is_null($customer)) {
                                    $text = Lang::get("bot.send_phone");
                                    try {
                                        $reply_markup = BotKeyboard::contact();
                                        // edit message reply markup
                                        Telegram::sendMessage([
                                            "chat_id" => $chat_id,
                                            "text" => $text,
                                            "parse_mode" => "Markdown",
                                            "reply_markup" => $reply_markup
                                        ]);

                                    } catch (Exception $e) {
                                        TelegramLog::log($e->getMessage());
                                    }
                                } else if (!is_null($customer)) {
                                    $order->phone = $customer->phone_number;
                                    if ($order->save()) {
                                        // update step
                                        $chatUser->step = Step::CHECK_LIST;
                                        $chatUser->save();

                                        $delivery = 0;
                                        if (!$order->isPickUp())
                                            $delivery = (float) Setting::get("delivery_price");

                                        $text = Lang::get("bot.your_order");

                                        $total = 0;
                                        $total_with_delivery = $delivery;
                                        foreach($order->details as $index => $detail) {
                                            $amount = $detail->price * $detail->quantity;
                                            $text .= ($index+1) .". <b>". $detail->product->translateorNew($locale)->name ." (";
                                            if (!is_null($detail->book))
                                                $text .= $detail->book->getBtnLabel($locale) .")</b>\n";
                                            $text .= "✏️   <i>" . GlobalFunc::moneyFormat($detail->price, false) ."</i> x "
                                            . $detail->quantity ." = <i>";
                                            $text .= GlobalFunc::moneyFormat($amount)."</i>\n";
                                            // calculate total
                                            $total += $amount;
                                            $total_with_delivery += $amount;
                                        }

                                        $text .= "\n";
                                        $text .= Lang::get("bot.amount")." <i>" . GlobalFunc::moneyFormat($total) . "</i>\n";
                                        $text .= Lang::get("bot.delivery") ." <i>" . GlobalFunc::moneyFormat($delivery)
                                        . "</i> " . Lang::get("bot.in_tashkent");
                                        $text .= Lang::get("bot.total") . " <i>" . GlobalFunc::moneyFormat($total_with_delivery) ."</i>";

                                        try {
                                            // main keyboard
                                            $reply_markup = BotKeyboard::main();
                                            Telegram::sendMessage([
                                                'chat_id' => $chat_id,
                                                'text' => Lang::get("bot.success_code"),
                                                'reply_markup' => $reply_markup
                                            ]);
                                            // send message
                                            $reply_markup = BotKeyboard::totalCheck($total_with_delivery, $order);
                                            $response = Telegram::sendMessage([
                                                'chat_id' => $chat_id,
                                                'text' => $text,
                                                'parse_mode' => "HTML",
                                                'reply_markup' => $reply_markup
                                            ]);

                                            // save total and delivery price
                                            $order->amount = $total;
                                            $order->delivery_price = $delivery;
                                            // save message ID, after successful payment remove inline keyboard
                                            $order->message_id = $response->getMessageId();
                                            $order->save();
                                        } catch (Exception $e) {
                                            TelegramLog::log($e->getMessage());
                                        }
                                    }
                                }
                            }

                        }
                    }

                    // get location
                    if (!is_null($location)) {
                        // save location
                        $order = ChatOrder::where([
                            "chat_id" => $chat_id,
                            "state" => ChatOrder::STATE_DRAF
                        ])->first();
                        if (!is_null($order)) {

                            $order->lat = $location->getLatitude();
                            $order->long = $location->getLongitude();
                            if ($order->save()) {
                                // update step
                                if (!is_null($chatUser)) {
                                    $chatUser->step = Step::LOCATION;
                                    $chatUser->save();
                                }
                                // save distance
                                $shop_lat = Setting::get('shop_lat');
                                $shop_lng = Setting::get('shop_lng');
                                $distance = null;
                                if (!empty($shop_lat) && !empty($shop_lng)) {
                                    $distance = GlobalFunc::haversineGreatCircleDistance($shop_lat, $shop_lng, $order->lat, $order->long);
                                    if (!is_null($distance) && $distance > 0) {
                                        $order->distance = $distance;
                                        $order->save();
                                    }
                                }
                            }

                            // agar nastroykada bermagan bo'lsa, ya'ni
                            // zakaz tushmagan bo'lsa avval tel nomer jo'natishi kerak
                            $customer = $chatUser->customer();
                            if (!$chatUser->existCustomer() || is_null($customer)) {
                                $text = Lang::get("bot.send_phone");
                                try {
                                    $reply_markup = BotKeyboard::contact();
                                    // edit message reply markup
                                    Telegram::sendMessage([
                                        "chat_id" => $chat_id,
                                        "text" => $text,
                                        "parse_mode" => "Markdown",
                                        "reply_markup" => $reply_markup
                                    ]);

                                } catch (Exception $e) {
                                    TelegramLog::log($e->getMessage());
                                }
                            } else if (!is_null($customer)) {
                                $order->phone = $customer->phone_number;
                                if ($order->save()) {
                                    // update step
                                    $chatUser->step = Step::CHECK_LIST;
                                    $chatUser->save();

                                    $delivery = 0;
                                    if (!$order->isPickUp())
                                        $delivery = (float) Setting::get("delivery_price");

                                    $text = Lang::get("bot.your_order");

                                    $total = 0;
                                    $total_with_delivery = $delivery;
                                    foreach($order->details as $index => $detail) {
                                        $amount = $detail->price * $detail->quantity;
                                        $text .= ($index+1) .". <b>". $detail->product->translateorNew($locale)->name ." (";
                                        if (!is_null($detail->book))
                                            $text .= $detail->book->getBtnLabel($locale) .")</b>\n";
                                        $text .= "✏️   <i>" . GlobalFunc::moneyFormat($detail->price, false) ."</i> x "
                                        . $detail->quantity ." = <i>";
                                        $text .= GlobalFunc::moneyFormat($amount)."</i>\n";
                                        // calculate total
                                        $total += $amount;
                                        $total_with_delivery += $amount;
                                    }

                                    $text .= "\n";
                                    $text .= Lang::get("bot.amount")." <i>" . GlobalFunc::moneyFormat($total) . "</i>\n";
                                    $text .= Lang::get("bot.delivery") ." <i>" . GlobalFunc::moneyFormat($delivery)
                                    . "</i> " . Lang::get("bot.in_tashkent");
                                    $text .= Lang::get("bot.total") . " <i>" . GlobalFunc::moneyFormat($total_with_delivery) ."</i>";

                                    try {
                                        // main keyboard
                                        $reply_markup = BotKeyboard::main();
                                        Telegram::sendMessage([
                                            'chat_id' => $chat_id,
                                            'text' => Lang::get("bot.success_code"),
                                            'reply_markup' => $reply_markup
                                        ]);
                                        // send message
                                        $reply_markup = BotKeyboard::totalCheck($total_with_delivery, $order);
                                        $response = Telegram::sendMessage([
                                            'chat_id' => $chat_id,
                                            'text' => $text,
                                            'parse_mode' => "HTML",
                                            'reply_markup' => $reply_markup
                                        ]);

                                        // save total and delivery price
                                        $order->amount = $total;
                                        $order->delivery_price = $delivery;
                                        // save message ID, after successful payment remove inline keyboard
                                        $order->message_id = $response->getMessageId();
                                        $order->save();
                                    } catch (Exception $e) {
                                        TelegramLog::log($e->getMessage());
                                    }
                                }
                            }
                        }
                    }

                    if (!is_null($contact)) {
                        if (!is_null($chatUser) && $chatUser->step == Step::CHANGE_PHONE) {
                            try {
                                $phone = GlobalFunc::removePlus($contact->getPhoneNumber());
                                $fullname = $contact->getFirstName();
                                if (!empty($contact->getLastName()))
                                    $fullname .= " ".$contact->getLastName();
                                // check
                                if (!$chatUser->existCustomer()) {
                                    // create customer
                                    $customer = Customer::create([
                                        'uid' => $chat_id,
                                        'phone_number' => $phone,
                                        'status' => Customer::STATUS_ACTIVE,
                                        'display_name' => $fullname,
                                        'customer_type' => Customer::TYPE_TELEGRAM
                                    ]);
                                    if (!is_null($customer)) {
                                        $chatUser->customer_id = $customer->id;
                                        $chatUser->save();
                                    }
                                } else {
                                    // update customer
                                    $customer = $chatUser->customer();
                                    if (!is_null($customer)) {
                                        $customer->display_name = $fullname;
                                        $customer->phone_number = $phone;
                                        $customer->save();
                                    }
                                }
                            } catch (\Throwable $th) {
                                TelegramLog::log($th->getMessage());
                            }

                            // send success message
                            $text = Lang::get("bot.success_code");
                            try {
                                $reply_markup = BotKeyboard::hideKeyboard();
                                Telegram::sendMessage([
                                    "chat_id" => $chat_id,
                                    "text" => $text,
                                    "parse_mode" => "Markdown",
                                    "reply_markup" => $reply_markup
                                ]);
                            } catch (Exception $e) {
                                TelegramLog::log($e->getMessage());
                            }

                            // send change phone message
                            $text = Lang::get("bot.change_customer_phone", ["phone" => "+".$customer->phone_number]);
                            try {
                                $reply_markup = BotKeyboard::changeContact($customer->phone_number);
                                Telegram::sendMessage([
                                    "chat_id" => $chat_id,
                                    "text" => $text,
                                    "parse_mode" => "Markdown",
                                    "reply_markup" => $reply_markup
                                ]);
                            } catch (Exception $e) {
                                TelegramLog::log($e->getMessage());
                            }
                        } else {
                            // save contact
                            $order = ChatOrder::where([
                                "chat_id" => $chat_id,
                                "state" => ChatOrder::STATE_DRAF
                            ])->first();
                            if (!is_null($order)) {
                                // remove plus if exists
                                $phone = GlobalFunc::removePlus($contact->getPhoneNumber());
                                $order->phone = $phone;
                                if ($order->save()) {
                                    // create customer
                                    try {
                                        if (!$chatUser->existCustomer()) {
                                            $fullname = $contact->getFirstName();
                                            if (!empty($contact->getLastName()))
                                                $fullname .= " ".$contact->getLastName();
                                            $customer = Customer::create([
                                                'uid' => $chat_id,
                                                'phone_number' => $phone,
                                                'status' => Customer::STATUS_ACTIVE,
                                                'display_name' => $fullname,
                                                'customer_type' => Customer::TYPE_TELEGRAM
                                            ]);
                                            if (!is_null($customer)) {
                                                $chatUser->customer_id = $customer->id;
                                                $chatUser->save();
                                            }
                                        }
                                    } catch (\Throwable $th) {
                                        TelegramLog::log($th->getMessage());
                                    }

                                    // check order already exists
                                    $old_order_count = ChatOrder::where([
                                        [ "chat_id", "=", $chat_id ],
                                        [ "state", "!=", ChatOrder::STATE_DRAF ]
                                    ])->count();

                                    if ($old_order_count > 0) {
                                        // update step
                                        $chatUser->step = Step::CHECK_LIST;
                                        $chatUser->save();

                                        $delivery = 0;
                                        if (!$order->isPickUp())
                                            $delivery = (float) Setting::get("delivery_price");

                                        $text = Lang::get("bot.your_order");

                                        $total = 0;
                                        $total_with_delivery = $delivery;
                                        foreach($order->details as $index => $detail) {
                                            $amount = $detail->price * $detail->quantity;
                                            $text .= ($index+1) .". <b>". $detail->product->translateorNew($locale)->name ." (";
                                            if (!is_null($detail->book))
                                                $text .= $detail->book->getBtnLabel($locale) .")</b>\n";
                                            $text .= "✏️   <i>" . GlobalFunc::moneyFormat($detail->price, false) ."</i> x "
                                            . $detail->quantity ." = <i>";
                                            $text .= GlobalFunc::moneyFormat($amount)."</i>\n";
                                            // calculate total
                                            $total += $amount;
                                            $total_with_delivery += $amount;
                                        }

                                        $text .= "\n";
                                        $text .= Lang::get("bot.amount")." <i>" . GlobalFunc::moneyFormat($total) . "</i>\n";
                                        $text .= Lang::get("bot.delivery") ." <i>" . GlobalFunc::moneyFormat($delivery)
                                        . "</i> " . Lang::get("bot.in_tashkent");
                                        $text .= Lang::get("bot.total") . " <i>" . GlobalFunc::moneyFormat($total_with_delivery) ."</i>";

                                        try {
                                            // main keyboard
                                            $reply_markup = BotKeyboard::main();
                                            Telegram::sendMessage([
                                                'chat_id' => $chat_id,
                                                'text' => Lang::get("bot.success_code"),
                                                'reply_markup' => $reply_markup
                                            ]);
                                            // send message
                                            $reply_markup = BotKeyboard::totalCheck($total_with_delivery, $order);
                                            $response = Telegram::sendMessage([
                                                'chat_id' => $chat_id,
                                                'text' => $text,
                                                'parse_mode' => "HTML",
                                                'reply_markup' => $reply_markup
                                            ]);

                                            // save total and delivery price
                                            $order->amount = $total;
                                            $order->delivery_price = $delivery;
                                            // save message ID, after successful payment remove inline keyboard
                                            $order->message_id = $response->getMessageId();
                                            $order->save();
                                        } catch (Exception $e) {
                                            TelegramLog::log($e->getMessage());
                                        }
                                    } else {

                                        $order->code = rand(1000, 9999);
                                        if ($order->save()) {
                                            // send sms for client
                                            $txt = "Tasdiqlash kodi
                                            Confirmation code: " . $order->code;
                                            Sms::send($order->phone, $txt);

                                            // send code
                                            $text = Lang::get("bot.send_code");
                                            try {
                                                $reply_markup = BotKeyboard::check_code();

                                                Telegram::sendMessage([
                                                    "chat_id" => $chat_id,
                                                    "text" => $text,
                                                    "reply_markup" => $reply_markup
                                                ]);
                                            } catch (Exception $e) {
                                                TelegramLog::log($e->getMessage());
                                            }

                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return ["ok" => true];
    }
}
