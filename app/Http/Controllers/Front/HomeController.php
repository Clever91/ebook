<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HomeController extends BaseController
{
    public function index()
    {
        // dd(App::getLocale());
        return view('front.home.index');
    }
}
