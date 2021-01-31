<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Admin\Author;
use App\Models\Helpers\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorController extends BaseController
{
    public function authors(Request $request)
    {
        if (($error = $this->authDevice($request)) !== true)
            return $error;

        $success = [];
        $success["page"] = $this->_page;
        $success["limit"] = $this->_limit;

        $query = DB::table('authors AS au')
            ->where([
                'au.status' => Base::STATUS_ACTIVE,
                'au.deleted' => Base::NO_DELETED,
            ]);

        // make filter by text
        $txt = $this->_text;
        if (!is_null($txt)) {
            $query->where('au.name', 'LIKE', '%'.$txt.'%');
            // or like
            $query->orWhere([
                [ 'au.status', '=', Base::STATUS_ACTIVE ],
                [ 'au.deleted', '=', Base::NO_DELETED ],
                [ 'au.bio', 'LIKE', '%'.$txt.'%' ]
            ]);
        }

        $query->select('au.id', 'au.name')
            ->orderBy('au.name');

        $success["total"] = $query->count();
        $success["items"] = $query->offset($this->_offset)->take($this->_limit)->get()->toArray();

        return $this->sendResponse($success, null);
    }

    public function author(Request $request)
    {
        if (($error = $this->authDevice($request)) !== true)
            return $error;

        $authorId = null;
        if ($request->has('author_id'))
            $authorId = $request->input('author_id');

        if (is_null($authorId))
            return $this->sendError('Author Error', ['error' => 'author_id must not be empty'], 400);

        $author = Author::find($authorId);

        if (is_null($author))
            return $this->sendError('Author Error', ['error' => 'Author is not found'], 400);

        if (!$author->isActive() || $author->isDeleted())
            return $this->sendError('Author Error', ['error' => 'Author is not found'], 400);

        $success = [];
        $success["id"] = $author->id;
        $success["name"] = $author->translateorNew($this->_lang)->name;
        $success["bio"] = $author->bio;
        $success["books"] = [];

        $item = [];
        $limit = $this->_limit;
        $offset = $this->_offset;
        $products = $author->products()->take($limit)->skip($offset)->get();
        foreach($products as $product) {
            $item['id'] = $product->id;
            $item['name'] = $product->translateOrNew($this->_lang)->name;
            $item['description'] = $product->translateOrNew($this->_lang)->description;
            $item['author'] = $author->name;
            $item['price'] = $product->price;
            $item['eprice'] = $product->eprice;

            $customer_id = null;
            if (!is_null($this->_customer)) {
                $customer_id = $this->_customer->id;
            }
            $item["bought"] = $product->isBought($customer_id);

            array_push($success["books"], $item);
        }

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
            return $this->sendError('Author Error', ['error' => 'width must not be null'], 400);

        $height = null;
        if ($request->has('height'))
            $height = intval($request->input('height'));

        if (is_null($height) || $height <= 0)
            return $this->sendError('Author Error', ['error' => 'height must not be null'], 400);

        $author_id = null;
        if ($request->has('author_id'))
            $author_id = $request->input('author_id');

        if (is_null($author_id))
            return $this->sendError('Author Error', ['error' => 'author_id must not be empty'], 400);

        $author = Author::find($author_id);

        if (is_null($author))
            return $this->sendError('Author Error', ['error' => 'Author is not found'], 400);

        $image_name = "no_image";
        if ($author->hasImage()) {
            $image_name = $author->image->name;
        }

        $path = public_path($author->getImage($width, $height));
        return response()->download($path, $image_name);
    }
}
