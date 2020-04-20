<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Author;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CommentController extends BaseController
{
    public function index(Request $request)
    {
        if (($error = $this->authApiDevice($request)) !== true)
            return $error;

        if (($error = $this->authCustomer($request)) !== true)
            return $error;

        $commentableId = $request->input('object_id');
        if (is_null($commentableId))
            return $this->sendError('Comment Error', ['error' => 'object_id must not be empty'], 400);

        $success = [];
        $success["page"] = $this->_page;
        $success["limit"] = $this->_limit;

        // return $this->sendResponse($objectId, null);
        
        $query = DB::table('comments AS com')
            ->join('customers AS cus', function($join) {
                $join->on('com.customer_id', '=', 'cus.id');
            });
            // ->where([
            //     'com.object_id' => $objectId,
            //     'com.type' => $type,
            // ]);

        $query->select('com.id AS comment_id', DB::raw('IF(cus.display_name, cus.display_name, "Unknown")'), 
            'com.created_at', 'com.text')
            ->addSelect(['replies' => Comment::select(DB::raw('COUNT(id) AS "replies"'))
                ->whereColumn([
                    'parent_id' => 'comments.id',
                    'status' => Comment::STATUS_ACTIVE
                ])
            ])
            ->orderByDesc('com.created_at');
        
        $success["total"] = $query->count();
        $success["items"] = $query->offset($this->_offset)->take($this->_limit)->get()->toArray();
        
        return $this->sendResponse($success, null);
    }

    public function add(Request $request)
    {
        if (($error = $this->authApiDevice($request)) !== true)
            return $error;

        if (($error = $this->authCustomer($request)) !== true)
            return $error;

        $commentableId = $request->input('object_id');
        if (is_null($commentableId))
            return $this->sendError('Comment Error', ['error' => 'object_id must not be empty'], 400);

        $type = $request->input('type');
        if (is_null($type))
            return $this->sendError('Comment Error', ['error' => 'type must not be empty'], 400);

        if (!in_array($type, (new Comment())->types()))
            return $this->sendError('Comment Error', ['error' => 'type format is incorrect'], 400);

        $body = $request->input('text');
        if (is_null($body))
            return $this->sendError('Comment Error', ['error' => 'text must not be empty'], 400);

        $body = strip_tags($body);
        $replyId = null;
        if ($request->has('parent_id')) {
            $replyId = $request->input('parent_id');
        }

        $object = null;
        $comment = new Comment();
        $comment->customer_id = $this->_customer->id;
        $comment->body = $body;
        $comment->status = Comment::STATUS_NO_ACTIVE;

        if ($type == "P") {
            $object = Product::find($commentableId);
            $object->comments()->save($comment);
        } else if ($type == "C") {
            $object = Category::find($commentableId);
            $object->comments()->save($comment);
        } else if ($type == "A") {
            $object = Author::find($commentableId);
            $object->comments()->save($comment);
        }

        if (!is_null($replyId) && !is_null($object)) {
            $reply = Comment::where([
                'id' => $replyId,
                'commentable_type' => get_class($object)
            ])->first();
            if (!is_null($reply)) {
                $comment->parent_id = $reply->id;
                $comment->save();
            }
        }

        $success = [];
        $success["comment_id"] = $comment->id;
        $success["object_id"] = $object->id;

        return $this->sendResponse($success, null);
    }

    public function delete(Request $request)
    {
        if (($error = $this->authApiDevice($request)) !== true)
            return $error;

        if (($error = $this->authCustomer($request)) !== true)
            return $error;

        $wishlistId = $request->input('wishlist_id');
        if (is_null($wishlistId))
            return $this->sendError('Wishlist Error', ['error' => 'wishlist_id must not be empty'], 400);

        $success = [];
        $wishlist = Wishlist::findOrFail($wishlistId);
        
        if (!is_null($wishlist)) {
            $wishlist->delete();
            $success["user_id"] = $this->_customer->id;

            return $this->sendResponse($success, null);
        }

        return $this->sendError('Wishlist Error', ['error' => 'Something is wrong'], 201);
    }
}
