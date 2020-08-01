<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Base;

class CategoryController extends BaseController
{
    public function categories(Request $request)
    {
        if (($error = $this->authDevice($request)) !== true)
            return $error;

        $success = [];
        $success["page"] = $this->_page;
        $success["limit"] = $this->_limit;
        
        $lang = $this->_lang;
        $query = DB::table('categories AS cat')
        ->leftJoin('category_translations AS ct', function ($join) use ($lang) {
            $join->on('cat.id', '=', 'ct.category_id')
            ->where('ct.locale', '=', $lang);
        })
        ->where([
            [ 'cat.status', '=', Base::STATUS_ACTIVE ],
            [ 'cat.deleted', '=', Base::NO_DELETED ]
        ]);
        
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

    public function image(Request $request)
    {
        if (($error = $this->authDevice($request)) !== true)
            return $error;

        $width = null;
        if ($request->has('width'))
            $width = intval($request->input('width'));

        if (is_null($width) || $width <= 0)
            return $this->sendError('Category Error', ['error' => 'width must not be null'], 400);
        
        $height = null;
        if ($request->has('height'))
            $height = intval($request->input('height'));

        if (is_null($height) || $height <= 0)
            return $this->sendError('Category Error', ['error' => 'height must not be null'], 400);

        $category_id = null;
        if ($request->has('category_id'))
            $category_id = $request->input('category_id');

        if (is_null($category_id))
            return $this->sendError('Category Error', ['error' => 'category_id must not be empty'], 400);

        $category = Category::find($category_id);

        if (is_null($category))
            return $this->sendError('Category Error', ['error' => 'Category is not found'], 400);

        $image_name = "no_image";
        if ($category->hasImage()) {
            $image_name = $category->image->name;
        }

        $path = public_path($category->getImage($width, $height));
        return response()->download($path, $image_name);
    }
}
