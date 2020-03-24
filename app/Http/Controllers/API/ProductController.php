<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\GroupRelation;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends BaseController
{
    public function products(Request $request)
    {
        if (($error = $this->authDevice($request)) !== true)
            return $error;
        
        // check category_id exists
        $category_id = null;
        if ($request->has("category_id")) {
            $category_id = $request->input("category_id");
        }

        // check author_id exists
        $author_id = null;
        if ($request->has("author_id")) {
            $author_id = $request->input("author_id");
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
        $type = GroupRelation::TYPE_PRODUCT;

        $query = DB::table('products AS pro')
        ->join('authors AS au', function($join) {
            $join->on('pro.author_id', '=', 'au.id');
        })
        ->leftJoin('product_translations AS pt', function ($join) use ($lang) {
            $join->on('pro.id', '=', 'pt.product_id')
            ->where('pt.locale', '=', $lang);
        })
        ->leftJoin('group_relations AS grel', function ($join) use ($type) {
            $join->on('pro.id', '=', 'grel.related_id')
                ->where('grel.type', '=', $type);
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

        // add author filter
        if (!is_null($author_id)) {
            $query->where('pro.author_id', $author_id);
        }

        // add group filter
        if (!is_null($group_id)) {
            $query->where('grel.group_id', $group_id);
        }

        $query->select(
            'pro.id', 'pt.name', 'pt.description', 
            'au.name AS author', 'pro.price', 'pro.eprice')
            ->orderBy('pt.name');
        
        $success["total"] = $query->count();
        $success["items"] = $query->offset($this->_offset)->take($this->_limit)->get()->toArray();
        
        return $this->sendResponse($success, null);
    }

    public function product(Request $request) 
    {
        if (($error = $this->authDevice($request)) !== true)
            return $error;

        $productId = null;
        if ($request->has('product_id'))
            $productId = $request->input('product_id');

        if (is_null($productId))
            return $this->sendError('Product Error', ['error' => 'product_id must not be empty'], 400);

        $product = Product::find($productId);

        if (is_null($product))
            return $this->sendError('Product Error', ['error' => 'Product is not found'], 400);

        $success = [];
        $success["id"] = $product->id;
        $success["name"] = $product->name;
        $success["description"] = $product->description;
        $success["author"] = $product->author->name;
        $success["price"] = $product->price;
        $success["eprice"] = $product->eprice;
        $success["recommended"] = [];
        
        return $this->sendResponse($success, null);
    }

}
