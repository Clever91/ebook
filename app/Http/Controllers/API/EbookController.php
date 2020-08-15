<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Order;
use App\Models\OrderEbook;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class EbookController extends BaseController
{
    public function index(Request $request)
    {
        if (($error = $this->authApiDevice($request)) !== true)
            return $error;

        if (($error = $this->authCustomer($request)) !== true)
            return $error;

        $success = [];
        $success["page"] = $this->_page;
        $success["limit"] = $this->_limit;

        $lang = $this->_lang;
        
        $query = DB::table('order_ebooks AS oe')
            ->join('products AS pro', function($join) {
                $join->on('oe.product_id', '=', 'pro.id');
            })
            ->join('authors AS au', function($join) {
                $join->on('pro.author_id', '=', 'au.id');
            })
            ->leftJoin('product_translations AS pt', function ($join) use ($lang) {
                $join->on('pro.id', '=', 'pt.product_id')
                ->where('pt.locale', '=', $lang);
            })
            ->where('oe.customer_id', '=', $this->_customer->id)
            ->where('oe.state', '=', OrderEbook::STATE_PAYED);

        $query->select(
            'pro.id', 'pt.name', 'pt.description', 'au.name AS author')
            ->orderBy('pt.name');
        
        $success["total"] = $query->count();
        $success["items"] = $query->offset($this->_offset)->take($this->_limit)->get()->toArray();
        
        return $this->sendResponse($success, null);
    }

    public function order(Request $request)
    {
        if (($error = $this->authApiDevice($request)) !== true)
            return $error;

        if (($error = $this->authCustomer($request)) !== true)
            return $error;

        $ids = $request->input('product_ids');
        if (is_null($ids) || empty($ids))
            return $this->sendError('Product Error', ['error' => 'product_ids must not be empty'], 400);

        $productIds = explode(",", $ids);
        if (!is_array($productIds)) {
            return $this->sendError('Product Error', ['error' => 'product_ids is incorrect'], 400);
        }

        $order = new Order();
        $order->customer_id = $this->_customer->id;
        $order->state = Order::STATE_NEW;
        $order->type = Order::TYPE_EBOOK;
        $order->save();
        
        $success = [];
        $success["order"] = [];

        $total = 0;
        $anyAvalible = false;
        foreach($productIds as $id) {
            $product = Product::find(trim($id));

            // check if product has exists
            if (!is_null($product))
                continue;
            
            // check if product is active
            if (!$product->isActive())
                continue;

            // check this has ebook
            if (!$product->hasEbook())
                continue;

            // check if customer already buyed this product
            if ($product->isBought($this->_customer->id) == 1);
                continue;
            
            // create order
            $ebook = new OrderEbook();
            $ebook->order_id = $order->id;
            $ebook->customer_id = $this->_customer->id;
            $ebook->product_id = $product->id;
            $ebook->price = $product->eprice;
            $ebook->discount = 0; // discount
            if ($ebook->save()) {
                $item = [];
                $item["id"] = $ebook->id;
                $item["price"] = $ebook->price;
                array_push($success["order"], $item);

                // calculate total
                $total += $ebook->price;
                $anyAvalible = true;
            }
        }

        // check any product buy
        if ($anyAvalible) {
            $order->total = $total;
            $order->save();
            
            $success["order_id"] = $order->id;
        } else {
            $order->delete();
            return $this->sendError('Order Error', ['error' => 'Any products are not valid'], 200);
        }

        return $this->sendResponse($success, null);
    }
}
