<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderEbook;
use Illuminate\Http\Request;

class PaymentController extends BaseController
{
    public function pay(Request $request)
    {
        if (($error = $this->authApiDevice($request)) !== true)
            return $error;

        if (($error = $this->authCustomer($request)) !== true)
            return $error;
   
        $order_id = $request->input('order_id');
        $order = Order::find($order_id);

        if (is_null($order))
            return $this->sendError('Order Error', ['error' => 'this order is not found'], 400);
        
        // check is test //todo: this is for TEST
        $is_test = false;
        if ($request->has("is_test"))
            $is_test = true;

        $success = [];
        if ($is_test) {
            foreach($order->ebooks as $book) {

                // qayta olmasligi bitta kitobni olmasligi uchun
                if ($book->product->isBought($this->_customer->id) == 1)
                    continue;
                
                $book->state = OrderEbook::STATE_PAYED;
                $book->save();
            }

            $order->state = Order::STATE_PAYED;
            $order->save();
        } else {
            //
        }
            
        return $this->sendResponse($success, null);
    }
    
    public function list(Request $request)
    {
        if (($error = $this->authApiDevice($request)) !== true)
            return $error;

        if (($error = $this->authCustomer($request)) !== true)
            return $error;

        $success = [];
        $success["items"] = [];

        $item["id"] = 1;
        $item["name"] = "Payme";
        $item["type"] = "payme";
        $item["state"] = true;
        array_push($success["items"], $item);

        $item["id"] = 1;
        $item["name"] = "Click";
        $item["type"] = "click";
        $item["state"] = true;
        array_push($success["items"], $item);
        
        return $this->sendResponse($success, null);
    }
}
