<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends BaseController
{
    public function products(Request $request)
    {
        // check category_id exists
        // $category_id = null;
        // if ($request->has("category_id")) {
        //     $category_id = $request->input("category_id");
        // }

        // check product_id exists
        // $category_id = null;
        // if ($request->has("category_id")) {
        //     $category_id = $request->input("category_id");
        // }

        $success = [];
        $success["page"] = $this->_page;
        $success["limit"] = $this->_limit;

        $lang = $this->_lang;
        $query = DB::table('products AS pro')
        ->leftJoin('product_translations AS pt', function ($join) use ($lang) {
            $join->on('pro.id', '=', 'pt.product_id')
            ->where('pt.locale', '=', $lang);
        })
        ->where('pro.status', '=', Product::STATUS_ACTIVE);
        
        // add text if not null
        $txt = $this->_text;
        if (!is_null($txt)) {
            $query->where('pt.name', 'LIKE', '%'.$txt.'%')
                ->orWhere('pt.description', 'LIKE', '%'.$txt.'%');
        }

        $query->select('pro.id', 'pt.name', 'pt.description', 'pro.price', 'pro.eprice')
            ->orderBy('pt.name');
        
        $success["total"] = $query->count();
        $success["items"] = $query->offset($this->_offset)->take($this->_limit)->get()->toArray();
        
        return $this->sendResponse($success, null);
    }
}
