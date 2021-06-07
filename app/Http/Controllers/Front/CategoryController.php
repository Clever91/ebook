<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use App\Models\Admin\Category;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function products(Request $request, $id)
    {
        $model = Category::findOrFail($id);
        return view('front.category.products', [
            'model' => $model
        ]);
    }
}
