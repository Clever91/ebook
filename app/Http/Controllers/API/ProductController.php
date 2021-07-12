<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Helpers\Base;
use App\Models\Admin\GroupRelation;
use App\Models\Admin\OrderEbook;
use App\Models\Admin\Product;
use Illuminate\Support\Facades\App;
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

        // ager access_token bilan auth qilgan bo'lsa,
        // demak olingan kitoblarni berish kerak
        $customer_id = null;
        if (!is_null($this->_customer)) {
            $customer_id = $this->_customer->id;
        }

        $query = DB::table('products AS pro')
        ->join('authors AS au', function($join) {
            $join->on('pro.author_id', '=', 'au.id');
        })
        ->leftJoin('author_translations AS aut', function ($join) use ($lang) {
            $join->on('au.id', '=', 'aut.author_id')
                ->where('aut.locale', '=', $lang);
        })
        ->leftJoin('product_translations AS pt', function ($join) use ($lang) {
            $join->on('pro.id', '=', 'pt.product_id')
                ->where('pt.locale', '=', $lang);
        })
        // ->leftJoin('order_ebooks AS oe', function ($join) use ($customer_id) {
        //     $join->on('pro.id', '=', 'oe.product_id')
        //         ->where([
        //             'oe.customer_id' => $customer_id,
        //             'oe.state' => OrderEbook::STATE_PAYED
        //         ]);
        // })
        ->leftJoin('group_relations AS grel', function ($join) use ($type) {
            $join->on('pro.id', '=', 'grel.related_id')
                ->where('grel.type', '=', $type);
        })
        ->where([
            [ 'pro.status', '=', Base::STATUS_ACTIVE ],
            [ 'pro.deleted', '=', Base::NO_DELETED ],
        ]);

        // add text filter
        $txt = $this->_text;
        if (!is_null($txt)) {
            $query->where('pt.name', 'LIKE', '%'.$txt.'%');
            // or like
            $query->orWhere([
                [ 'pro.status', '=', Base::STATUS_ACTIVE ],
                [ 'pro.deleted', '=', Base::NO_DELETED ],
                [ 'pt.description', 'LIKE', '%'.$txt.'%' ]
            ]);
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
            'aut.name AS author', DB::raw("0 AS 'price'"), DB::raw("0 AS 'eprice'"),
            // DB::raw("IF (oe.id IS NULL, false, true) AS 'bought'")
            )
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

        if (!$product->isActive() || $product->isDeleted())
            return $this->sendError('Product Error', ['error' => 'Product is not found'], 400);

        $success = [];
        $success["id"] = $product->id;
        $success["name"] = $product->translateOrNew($this->_lang)->name;
        $success["description"] = $product->translateOrNew($this->_lang)->description;
        $success["author"] = $product->authorName();
        $success["price"] = $product->bookPrice();
        $success["eprice"] = $product->ebookPrice();
        // $success["ebook"] = $product->hasEbook();

        // $customer_id = null;
        // if (!is_null($this->_customer)) {
        //     $customer_id = $this->_customer->id;
        // }
        // $success["bought"] = $product->isBought($customer_id);
        $success["recommended"] = [];

        return $this->sendResponse($success, null);
    }

    public function image(Request $request)
    {
        if (($error = $this->authDevice($request)) !== true)
            return $error;

        $width = null;
        if ($request->has('width'))
            $width = intval($request->input('width'));

        if (is_null($width) || $width <= 0)
            return $this->sendError('Product Error', ['error' => 'width must not be null'], 400);

        $height = null;
        if ($request->has('height'))
            $height = intval($request->input('height'));

        if (is_null($height) || $height <= 0)
            return $this->sendError('Product Error', ['error' => 'height must not be null'], 400);

        $productId = null;
        if ($request->has('product_id'))
            $productId = $request->input('product_id');

        if (is_null($productId))
            return $this->sendError('Product Error', ['error' => 'product_id must not be empty'], 400);

        $product = Product::find($productId);

        if (is_null($product))
            return $this->sendError('Product Error', ['error' => 'Product is not found'], 400);

        $image_name = "no_image";
        if ($product->hasImage()) {
            $image_name = $product->image->name;
        }

        $path = public_path($product->getImage($width, $height));
        return response()->download($path, $image_name);
    }

    public function download(Request $request)
    {
        if (($error = $this->authApiDevice($request)) !== true)
            return $error;

        if (($error = $this->authCustomer($request)) !== true)
            return $error;

        $productId = null;
        if ($request->has('product_id'))
            $productId = $request->input('product_id');

        if (is_null($productId))
            return $this->sendError('Product Error', ['error' => 'product_id must not be empty'], 400);

        $product = Product::find($productId);

        if (is_null($product))
            return $this->sendError('Product Error', ['error' => 'Product is not found'], 400);

        // check this has ebook
        // if (!$product->hasEbook())
        //     return $this->sendError('Product Error', ['error' => 'This product has not ebook'], 400);

        // must to check this product is payed
        $ebook = OrderEbook::where([
            'customer_id' => $this->_customer->id,
            'product_id' => $product->id,
            'state' => OrderEbook::STATE_PAYED
        ])->first();

        if (is_null($ebook))
            return $this->sendError('Product Error', ['error' => 'This product is not payed'], 200);

        // this is default epub for test
        // $path = public_path('default/free_book.epub');
        $path = $product->file->getFilePath();
        return response()->download($path, $product->translateorNew(App::getLocale())->name);
    }

}
