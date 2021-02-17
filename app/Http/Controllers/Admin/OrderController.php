<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Order;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public function index(Request $request)
    {
        $models = Order::orderByDesc('created_at')->paginate($this->_limit);
        return view('admin.order.index', compact('models'));
    }
}
