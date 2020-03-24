<?php

namespace App\Http\Controllers\API;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\GroupRelation;

class HomeController extends BaseController
{
    public function store(Request $request)
    {
        if (($error = $this->authDevice($request)) !== true)
            return $error;

        $success = [];
        $success['items'] = [];

        // get all groups only active
        $groups = Group::where('status', Group::STATUS_ACTIVE)->orderBy('order_no')->get();
        foreach($groups as $group) {
            $item = [];
            $categories = $group->relations()
                ->where('type', GroupRelation::TYPE_CATEGORY)->get();
            $authors = $group->relations()
                ->where('type', GroupRelation::TYPE_AUTHOR)->get();
            $products = $group->relations()
                ->where('type', GroupRelation::TYPE_PRODUCT)->get();
            
            if ($categories->count()) {
                $item["group_id"] = $group->id;
                $item["name"] = $group->name;
                $item["order_no"] = $group->order_no;
                $item["type"] = GroupRelation::TYPE_CATEGORY;

                $item["item"] = [];
                foreach($categories as $index => $groupcat) {
                    $item["item"][$index]["id"] = $groupcat->category->id;
                    $item["item"][$index]["name"] = $groupcat->category->name;
                    $item["item"][$index]["order_no"] = $groupcat->order_no;
                    // $item["item"][$index]["image"] = $groupcat->category->getImageUrl();
                }

                array_push($success['items'], $item);
            } else if ($authors->count() > 0) {
                $item["group_id"] = $group->id;
                $item["name"] = $group->name;
                $item["order_no"] = $group->order_no;
                $item["type"] = GroupRelation::TYPE_AUTHOR;

                $item["item"] = [];
                foreach($authors as $index => $groAuthor) {
                    $item["item"][$index]["id"] = $groAuthor->author->id;
                    $item["item"][$index]["name"] = $groAuthor->author->name;
                    $item["item"][$index]["bio"] = $groAuthor->author->bio;
                    $item["item"][$index]["order_no"] = $groAuthor->order_no;
                    // $item["item"][$index]["image"] = $groupcat->category->getImageUrl();
                }

                array_push($success['items'], $item);
            } else if ($products->count() > 0) {
                $item["group_id"] = $group->id;
                $item["name"] = $group->name;
                $item["order_no"] = $group->order_no;
                $item["type"] = GroupRelation::TYPE_PRODUCT;

                $item["item"] = [];
                foreach($products as $index => $gropro) {
                    $item["item"][$index]["id"] = $gropro->product->id;
                    $item["item"][$index]["name"] = $gropro->product->name;
                    $item["item"][$index]["price"] = (float) $gropro->product->price;
                    $item["item"][$index]["eprice"] = (float) $gropro->product->eprice;
                    $item["item"][$index]["order_no"] = $gropro->order_no;
                    // $item["item"][$index]["image"] = $groupcat->category->getImageUrl();
                }

                array_push($success['items'], $item);
            }
        }
    
        return $this->sendResponse($success, null);
    }
}
