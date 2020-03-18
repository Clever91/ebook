<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\API\BaseController as BaseController;

class CategoryController extends BaseController
{
    public function categories(Request $request)
    {
        $success = [];
        $success["page"] = $this->_page;
        $success["limit"] = $this->_limit;
        
        $lang = $this->_lang;
        $query = DB::table('categories AS cat')
        ->leftJoin('category_translations AS ct', function ($join) use ($lang) {
            $join->on('cat.id', '=', 'ct.category_id')
            ->where('ct.locale', '=', $lang);
        })
        ->where('cat.status', '=', Category::STATUS_ACTIVE);
        
        // add text if not null
        $txt = $this->_text;
        if (!is_null($txt))
            $query->where('ct.name', 'LIKE', '%'.$txt.'%');

        $query->select('cat.id', 'ct.name', 'cat.order_no')
        ->orderBy('cat.order_no');
        
        $success["total"] = $query->count();
        $success["items"] = $query->offset($this->_offset)->take($this->_limit)->get()->toArray();
        
        return $this->sendResponse($success, null);
    }
}
