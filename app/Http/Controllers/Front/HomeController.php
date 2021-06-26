<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use App\Models\Admin\Product;
use App\Models\Helpers\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HomeController extends BaseController
{
    public function index()
    {
        $currency = $this->_currency;
        $lang = App::getLocale();
        $featured = Product::where([
            'status' => Base::STATUS_ACTIVE,
            'deleted' => Base::NO_DELETED,
        ])->take(10)->skip(0)->get();
        $onSale = Product::where([
            'status' => Base::STATUS_ACTIVE,
            'deleted' => Base::NO_DELETED,
        ])->take(10)->skip(10)->get();
        $mostVieved = Product::where([
            'status' => Base::STATUS_ACTIVE,
            'deleted' => Base::NO_DELETED,
        ])->take(10)->skip(20)->get();

        $dealsOfWeek = Product::where([
            'status' => Base::STATUS_ACTIVE,
            'deleted' => Base::NO_DELETED,
        ])->take(10)->skip(30)->get();
        $productsByTag = Product::where([
            'status' => Base::STATUS_ACTIVE,
            'deleted' => Base::NO_DELETED,
        ])->take(15)->skip(0)->get();
        $biographiesBook = Product::where([
            'status' => Base::STATUS_ACTIVE,
            'deleted' => Base::NO_DELETED,
        ])->take(15)->skip(15)->get();

        return view('front.home.index', [
            'lang' => $lang,
            'currency' => $currency,
            'featured' => $featured,
            'onSale' => $onSale,
            'mostVieved' => $mostVieved,
            'dealsOfWeek' => $dealsOfWeek,
            'productsByTag' => $productsByTag,
            'biographiesBook' => $biographiesBook,
        ]);
    }
}
