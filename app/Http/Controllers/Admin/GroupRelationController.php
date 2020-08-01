<?php

namespace App\Http\Controllers\Admin;

use App\Models\Author;
use App\Models\Category;
use App\Models\Group;
use App\Models\GroupRelation;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupRelationController extends BaseController
{
    public function index(Request $request, $id, $type)
    {
        $relation = null;
        $groups = Group::where([
            'status' => Group::STATUS_ACTIVE,
            'deleted' => Group::NO_DELETED,
        ])->get();

        if ($type == GroupRelation::TYPE_PRODUCT)
            $relation = Product::findOrFail($id);
        else if ($type == GroupRelation::TYPE_CATEGORY)
            $relation = Category::findOrFail($id);
        else if ($type == GroupRelation::TYPE_AUTHOR)
            $relation = Author::findOrFail($id);

        $related = GroupRelation::where([
            'type' => $type,
            'related_id' => $relation->id,
        ])->pluck('group_id')->toArray();

        return view('admin.relation.index')->with([
            'relation_id' => $id,
            'type' => $type,
            'groups' => $groups,
            'related' => $related,
            'relation' => $relation,
        ]);
    }

    public function store(Request $request, $id, $type)
    {
        $request->validate([
            'groups' => 'required',
            'order_no' => 'required',
        ]);

        $relation = null;
        $groups = $request->input('groups');
        $order_no = $request->input('order_no');

        if ($type == GroupRelation::TYPE_PRODUCT)
            $relation = Product::findOrFail($id);
        else if ($type == GroupRelation::TYPE_CATEGORY)
            $relation = Category::findOrFail($id);
        else if ($type == GroupRelation::TYPE_AUTHOR)
            $relation = Author::findOrFail($id);

        if (is_null($relation))
            return back();

        $old_related = GroupRelation::where([
            'type' => $type,
            'related_id' => $relation->id,
        ])->get();

        $new_related = [];
        foreach($groups as $group_id) {
            $gr_relation = GroupRelation::where([
                'group_id' => $group_id,
                'type' => $type,
                'related_id' => $relation->id,
            ])->first();
            if (is_null($gr_relation)) {
                $gr_relation = new GroupRelation();
                $gr_relation->related_id = $relation->id;
                $gr_relation->group_id = $group_id;
                $gr_relation->type = $type;
                $gr_relation->created_by = Auth::user()->id;
            } else {
                $gr_relation->updated_by = Auth::user()->id;
            }
            $gr_relation->order_no = $order_no;
            $gr_relation->save();

            array_push($new_related, $gr_relation->id);
        }

        // delete old
        foreach($old_related as $related)
            if (!in_array($related->id, $new_related))
                $related->delete();

        if ($type == GroupRelation::TYPE_PRODUCT)
            return redirect()->route('product.index');
        else if ($type == GroupRelation::TYPE_CATEGORY)
            return redirect()->route('category.index');
        else if ($type == GroupRelation::TYPE_AUTHOR)
            return redirect()->route('author.index');
        
        return back();
    }
}
