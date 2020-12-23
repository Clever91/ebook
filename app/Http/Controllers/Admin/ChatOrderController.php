<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bot\ChatOrder;

class ChatOrderController extends Controller
{
    public function index()
    {
        $models = ChatOrder::orderBy('id DESC')->paginate(15);
        return view('admin.chatOrder.index', compact('models'));
    }
}
