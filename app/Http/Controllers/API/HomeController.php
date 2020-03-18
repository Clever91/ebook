<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Category;
use App\Models\Device;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class HomeController extends BaseController
{
    public function store(Request $request)
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
                    $item["item"][$index]["image"] = $groupcat->category->getImageUrl();
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
                    $item["item"][$index]["image"] = $grouppro->product->getImageUrl();
                }

                array_push($success['items'], $item);
            }
        }
    
        return $this->sendResponse($success, null);
    }

    public function categories(Request $request)
    {
        $page = 0;
        $limit = 15;

        // this is for search
        $txt = null;
        if ($request->has("text")) {
            $txt = $request->input("text");
            $txt = trim($txt);
            if (empty($txt))
                $txt = null;
        }

        if ($request->has("page")) {
            $page = (int) $request->input("page");
            if ($page < 0)
                $page = 0;
        }

        if ($request->has("limit")) {
            $limit = (int) $request->input("limit");
            if ($limit < 0)
                $limit = 15;
        }

        // get offset
        $offset = $page * $limit;

        // get language
        $lang = $request->input('lang');
        if (is_null($lang))
            $lang = config('app.locale');

        // set language
        // App::setLocale($lang);
        
        $success = [];
        $success["page"] = $page;
        $success["limit"] = $limit;
        
        $query = DB::table('categories AS cat')
        ->leftJoin('category_translations AS ct', function ($join) use ($lang) {
            $join->on('cat.id', '=', 'ct.category_id')
            ->where('ct.locale', '=', $lang);
        })
        ->where('cat.status', '=', Category::STATUS_ACTIVE);
        
        // add text if not null
        if (!is_null($txt))
            $query->where('ct.name', 'LIKE', '%'.$txt.'%');

        $query->select('cat.id', 'ct.name', 'cat.order_no')
        ->orderBy('cat.order_no');
        
        $success["total"] = $query->count();
        $success["items"] = $query->offset($offset)->take($limit)->get()->toArray();
        
        return $this->sendResponse($success, null);
    }
}
