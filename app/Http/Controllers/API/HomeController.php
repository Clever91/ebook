<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Device;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HomeController extends BaseController
{
    public function welcome(Request $request)
    {
        $device = Device::where([
            'status' => Device::STATUS_ACTIVE,
            'token' => $request->input('token'),
        ])->first();
        
        if (is_null($device))
            return $this->sendError('Device Error', ['error'=>'This token does not exists']); 

        $lang = $request->input('lang');
        if (is_null($lang))
            $lang = config('app.locale');

        // set language
        App::setLocale($lang);

        $success = [];
        $success['items'] = [];

        // get all groups only active
        $groups = Group::where('status', Group::STATUS_ACTIVE)->orderBy('order_no')->get();
        foreach($groups as $group) {
            $item = [];
            if ($group->groupcats()->count()) {
                $item["group_id"] = $group->id;
                $item["name"] = $group->name;
                $item["type"] = Group::TYPE_CATEGORY;
                $item["order_no"] = $group->order_no;

                $item["item"] = [];
                foreach($group->groupcats()->get() as $index => $groupcat) {
                    $item["item"][$index]["id"] = $groupcat->category->id;
                    $item["item"][$index]["name"] = $groupcat->category->name;
                    $item["item"][$index]["order_no"] = $groupcat->order_no;
                    $item["item"][$index]["image"] = url('/images/no_book.jpg');
                }

                array_push($success['items'], $item);
            } else if ($group->grouppros()->count()) {
                $item["group_id"] = $group->id;
                $item["name"] = $group->name;
                $item["type"] = Group::TYPE_PRODUCT;
                $item["order_no"] = $group->order_no;

                $item["item"] = [];
                foreach($group->grouppros()->get() as $index => $grouppro) {
                    $item["item"][$index]["id"] = $grouppro->product->id;
                    $item["item"][$index]["name"] = $grouppro->product->name;
                    $item["item"][$index]["order_no"] = $grouppro->order_no;
                    $item["item"][$index]["image"] = url('/images/no_book.jpg');
                }

                array_push($success['items'], $item);
            }
        }
    
        return $this->sendResponse($success, null);
    }
}
