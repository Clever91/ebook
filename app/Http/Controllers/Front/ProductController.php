<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use App\Models\Admin\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function single(Request $request, $id)
    {
        $model = Product::findOrFail($id);
        $lang = $this->_lang;
        return view('front.product.single', [
            'product' => $model,
            'lang' => $lang,
        ]);
    }
}
