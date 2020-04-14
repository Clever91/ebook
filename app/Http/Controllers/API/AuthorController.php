<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Author;
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
            ->where('au.status', '=', Author::STATUS_ACTIVE);
        
        // make filter by text
        $txt = $this->_text;
        if (!is_null($txt)) {
            $query->where('au.name', 'LIKE', '%'.$txt.'%');
            $query->orWhere('au.bio', 'LIKE', '%'.$txt.'%');
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

        $success = [];
        $success["id"] = $author->id;
        $success["name"] = $author->name;
        $success["bio"] = $author->bio;
        $success["books"] = [];

        $item = [];
        $limit = $this->_limit;
        $offset = $this->_offset;
        $products = $author->products()->take($limit)->skip($offset)->get();
        foreach($products as $product) {
            $item['id'] = $product->id;
            $item['name'] = $product->name;
            $item['description'] = $product->description;
            $item['author'] = $author->name;
            $item['price'] = $product->price;
            $item['eprice'] = $product->eprice;

            array_push($success["books"], $item);
        }
        
        return $this->sendResponse($success, null);
    }
}