<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bot\ChatGroup;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends BaseController
{
    public function index(Request $request, $id)
    {
        $model = Product::findOrFail($id);

        if (!$model->hasImage())
            return back();

        return view('admin.telegram.index', compact('model'));
    }

    public function send(Request $request, $id)
    {
        // make 500 x 500 image for telegram
        $product = Product::findOrFail($id);
        $product->image->resizeImage(500, 500);

        $page = 0;
        if ($request->has('page'))
            $page = $request->input('page');

        $limit = 20;
        $offset = $page * $limit;

        // make ready params
        $thumbnail = $product->image->getImageUrl("500x500");
        $url = $request->getHttpHost() . "" . $thumbnail;
        $caption = $request->input('caption');

        $result = [];
        $models = ChatGroup::offset($offset)->take($limit)->get();
        foreach($models as $model) {
            try {
                // send message
                Telegram::sendPhoto([
                    'chat_id' => $model->chat_id,
                    'photo' => $url,
                    'caption' => $caption
                ]);

                $item = [];
                $item["success"] = true;
                $item["name"] = $model->title;
                $item["caption"] = $caption;
                array_push($result, $item);

            } catch (Exception $e) {
                dd($e->getMessage());
                Telegram::sendMessage([
                    'chat_id' => 122420625, 
                    'text' => $e->getMessage()
                ]);

                $item = [];
                $item["success"] = false;
                $item["name"] = $model->title;
                $item["caption"] = $caption;
                array_push($result, $item);
            }
        }

        return view('admin.telegram.send')->with([
            'page' => $page,
            'result' => $result,
        ]);
    }
}
