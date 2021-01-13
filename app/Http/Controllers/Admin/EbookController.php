<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Order;
use Illuminate\Http\Request;

class EbookController extends BaseController
{
    public function index(Request $request)
    {
        $models = Order::where(['type' => Order::TYPE_EBOOK])->orderByDesc('created_at')->paginate($this->_limit);
        return view('admin.ebook.index', compact('models'));
    }
}
