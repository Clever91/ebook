<?php

namespace App\Http\Controllers\API;

use App\Models\Admin\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Helpers\Base;
use App\Models\Admin\GroupRelation;

class HomeController extends BaseController
{
    public function store(Request $request)
    {
        if (($error = $this->authDevice($request)) !== true)
            return $error;

        $success = [];
        $success['items'] = [];

        // get all only active groups
        $groups = Group::where([
            'status' => Base::STATUS_ACTIVE,
            'deleted' => Base::NO_DELETED,
        ])->orderBy('order_no')->get();

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
                $item["name"] = $group->translateOrNew($this->_lang)->name;
                $item["order_no"] = $group->order_no;
                $item["type"] = GroupRelation::TYPE_CATEGORY;

                $index = 0;
                $item["item"] = [];
                foreach($categories as $groupcat) {

                    if (is_null($groupcat->category))
                        continue;

                    if (!$groupcat->category->isActive())
                        continue;

                    $item["item"][$index]["id"] = $groupcat->category->id;
                    $item["item"][$index]["name"] = $groupcat->category->translateOrNew($this->_lang)->name;
                    $item["item"][$index]["order_no"] = $groupcat->order_no;
                    $index++;
                }

                array_push($success['items'], $item);
            } else if ($authors->count() > 0) {
                $item["group_id"] = $group->id;
                $item["name"] = $group->translateOrNew($this->_lang)->name;
                $item["order_no"] = $group->order_no;
                $item["type"] = GroupRelation::TYPE_AUTHOR;

                $index = 0;
                $item["item"] = [];
                foreach($authors as $groAuthor) {

                    if (is_null($groAuthor->author))
                        continue;

                    if (!$groAuthor->author->isActive())
                        continue;

                    $item["item"][$index]["id"] = $groAuthor->author->id;
                    $item["item"][$index]["name"] = $groAuthor->author->name;
                    $item["item"][$index]["bio"] = $groAuthor->author->bio;
                    $item["item"][$index]["order_no"] = $groAuthor->order_no;
                    $index++;
                }

                array_push($success['items'], $item);
            } else if ($products->count() > 0) {
                $item["group_id"] = $group->id;
                $item["name"] = $group->translateOrNew($this->_lang)->name;
                $item["order_no"] = $group->order_no;
                $item["type"] = GroupRelation::TYPE_PRODUCT;

                $index = 0;
                $item["item"] = [];
                foreach($products as $index => $gropro) {

                    if (is_null($gropro->product))
                        continue;

                    if (!$gropro->product->isActive())
                        continue;

                    $item["item"][$index]["id"] = $gropro->product->id;
                    $item["item"][$index]["name"] = $gropro->product->translateOrNew($this->_lang)->name;
                    $item["item"][$index]["price"] = (float) $gropro->product->price;
                    $item["item"][$index]["eprice"] = (float) $gropro->product->eprice;
                    $item["item"][$index]["order_no"] = $gropro->order_no;

                    // tekshirish kerak auth bo'lganini, agar bo'lgan bo'lsa
                    // demak olgan kitoblarini berishimiz kerak
                    $customer_id = null;
                    if (!is_null($this->_customer)) {
                        $customer_id = $this->_customer->id;
                    }
                    $item["item"][$index]["bought"] = $gropro->product->isBought($customer_id);
                    $index++;
                }

                array_push($success['items'], $item);
            }
        }

        return $this->sendResponse($success, null);
    }
}
