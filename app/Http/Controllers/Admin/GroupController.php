<?php

namespace App\Http\Controllers\Admin;

use App\Models\Base;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lunaweb\Localization\Facades\Localization;

class GroupController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Group::where('deleted', Base::NO_DELETED)->orderByDesc('created_at')
            ->paginate($this->_limit);
        return view('admin.group.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.group.create')->with([
            'model' => new Group()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|min:3',
            'order_no' => 'required',
        ]);
        
        // create default category
        $model = new Group();
        foreach(Localization::getLocales() as $lang => $item) {
            $model->translateOrNew($lang)->name = $request->input('name');
            $model->translateOrNew($lang)->is_default = 0;
            if (env("LANG_DEFAULT") == $lang)
                $model->translateOrNew($lang)->is_default = 1;
        }
        $model->order_no = $request->input('order_no');
        $model->status = Base::activeOn($request->input("status"));;
        $model->created_by = Auth::user()->id;
        $model->save();

        return redirect()->route('group.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Group::findOrFail($id);

        return view('admin.group.edit')->with([
            'model' => $model
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $attributes = $request->validate([
            'name' => 'required|min:3',
            'order_no' => 'required',
        ]);
        
        $model = Group::findOrFail($id);
        $model->translateOrNew($this->_lang)->name = $request->input('name');
        $model->order_no = $request->input('order_no');
        $model->status = Base::activeOn($request->input("status"));;
        $model->save();

        return redirect()->route('group.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Group::findOrFail($id);
        $model->makeDeleted();

        return redirect()->route('group.index');
    }
}
