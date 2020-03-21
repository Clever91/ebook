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
        $category_id = null;
        if ($request->has("category_id")) {
            $category_id = $request->input("category_id");
        }

        // check group_id exists
        $group_id = null;
        if ($request->has("group_id")) {
            $group_id = $request->input("group_id");
        }

        $success = [];
        $success["page"] = $this->_page;
        $success["limit"] = $this->_limit;

        $lang = $this->_lang;
        $query = DB::table('products AS pro')
        ->leftJoin('product_translations AS pt', function ($join) use ($lang) {
            $join->on('pro.id', '=', 'pt.product_id')
            ->where('pt.locale', '=', $lang);
        })
        ->leftJoin('group_products AS gp', function ($join) {
            $join->on('pro.id', '=', 'gp.product_id');
        })
        ->where('pro.status', '=', Product::STATUS_ACTIVE);
        
        // add text filter
        $txt = $this->_text;
        if (!is_null($txt)) {
            $query->where('pt.name', 'LIKE', '%'.$txt.'%')
                ->orWhere('pt.description', 'LIKE', '%'.$txt.'%');
        }

        // add category filter
        if (!is_null($category_id)) {
            $query->where('pro.category_id', $category_id);
        }

        // add group filter
        if (!is_null($group_id)) {
            $query->where('gp.group_id', $group_id);
        }

        $query->select(
            'pro.id', 'pt.name', 'pt.description', 
            'pro.price', 'pro.eprice')
            ->orderBy('pt.name');
        
        $success["total"] = $query->count();
        $success["items"] = $query->offset($this->_offset)->take($this->_limit)->get()->toArray();
        
        return $this->sendResponse($success, null);
    }
}
