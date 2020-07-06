<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public function index(Request $request)
    {
        return redirect()->route('admin.ebook.index');
    }
}
