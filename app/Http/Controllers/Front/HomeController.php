<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function index()
    {
        return view('front.home.index');
    }
}
