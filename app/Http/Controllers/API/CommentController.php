<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Admin\Author;
use App\Models\Admin\Category;
use App\Models\Admin\Comment;
use App\Models\Admin\Product;
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

        $type = $request->input('type');
        if (is_null($type))
            return $this->sendError('Comment Error', ['error' => 'type must not be empty'], 400);

        if (!in_array($type, (new Comment())->types()))
            return $this->sendError('Comment Error', ['error' => 'type format is incorrect'], 400);

        $success = [];
        $success["page"] = $this->_page;
        $success["limit"] = $this->_limit;

        $object = null;
        if ($type == "P") {
            $object = Product::find($commentableId);
        } else if ($type == "C") {
            $object = Category::find($commentableId);
        } else if ($type == "A") {
            $object = Author::find($commentableId);
        }

        $success["total"] = $object->comments()->count();
        $success["items"] = $object->comments()
            ->offset($this->_offset)
            ->take($this->_limit)
            ->select('id AS comment_id', 'body AS text', 'created_at AS date')
            ->get()
            ->toArray();

        foreach($success["items"] as &$comment) {
            $reply = Comment::find($comment["comment_id"]);
            $comment["user_name"] = $reply->customer->displayName();
            $comment["replies"] = $reply->replies()->count();
        }

        return $this->sendResponse($success, null);
    }

    public function replies(Request $request)
    {
        if (($error = $this->authApiDevice($request)) !== true)
            return $error;

        if (($error = $this->authCustomer($request)) !== true)
            return $error;

        $commentId = $request->input('comment_id');
        if (is_null($commentId))
            return $this->sendError('Comment Error', ['error' => 'comment_id must not be empty'], 400);

        $success = [];
        $comment = Comment::findOrFail($commentId);

        $success = [];
        $success["page"] = $this->_page;
        $success["limit"] = $this->_limit;

        $success["total"] = $comment->replies()->count();
        $success["items"] = $comment->replies()
            ->offset($this->_offset)
            ->take($this->_limit)
            ->select('id AS comment_id', 'body AS text', 'created_at AS date')
            ->get()
            ->toArray();

        foreach($success["items"] as &$comment) {
            $reply = Comment::find($comment["comment_id"]);
            $comment["user_name"] = $reply->customer->displayName();
            $comment["replies"] = $reply->replies()->count();
        }

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
        $comment->status = Comment::STATUS_ACTIVE;

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
                'commentable_type' => $object->getMorphClass()
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

        $commentId = $request->input('comment_id');
        if (is_null($commentId))
            return $this->sendError('Comment Error', ['error' => 'comment_id must not be empty'], 400);

        $success = [];
        $success["user_id"] = $this->_customer->id;
        $comment = Comment::findOrFail($commentId);

        if ($comment->replies()->count() > 0) {
            $comment->body = "";
            $comment->save();
        } else {
            $comment->delete();
        }

        return $this->sendResponse($success, null);
    }
}
