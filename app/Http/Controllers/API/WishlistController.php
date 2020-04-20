<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Wishlist;
use Illuminate\Support\Facades\DB;

class WishlistController extends BaseController
{
    public function index(Request $request)
    {
        if (($error = $this->authApiDevice($request)) !== true)
            return $error;

        if (($error = $this->authCustomer($request)) !== true)
            return $error;

        $success = [];
        $success["page"] = $this->_page;
        $success["limit"] = $this->_limit;
        
        $query = DB::table('wishlists AS wish')
            ->where('wish.customer_id', '=', $this->_customer->id);

        $query->select('wish.id AS wishlist_id', 'wish.object_id', 'wish.type')
            ->orderBy('wish.created_at');
        
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

        $objectId = $request->input('object_id');
        if (is_null($objectId))
            return $this->sendError('Wishlist Error', ['error' => 'object_id must not be empty'], 400);

        $type = $request->input('type');
        if (is_null($type))
            return $this->sendError('Wishlist Error', ['error' => 'type must not be empty'], 400);

        if (!in_array($type, (new Wishlist)->types()))
            return $this->sendError('Wishlist Error', ['error' => 'type format is incorrect'], 400);

        $wishlist = Wishlist::where([
            'type' => $type,
            'object_id' => $objectId,
            'customer_id' => $this->_customer->id
        ])->first();
        if (is_null($wishlist)) {
            $wishlist = Wishlist::create([
                'type' => $type,
                'object_id' => $objectId,
                'customer_id' => $this->_customer->id
            ]);
        }

        $success = [];
        $success["wishlist_id"] = $wishlist->id;
        $success["object_id"] = $wishlist->object_id;

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
