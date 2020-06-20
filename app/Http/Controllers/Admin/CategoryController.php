<?php

namespace App\Http\Controllers\Admin;

use App\Models\Base;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Lunaweb\Localization\Facades\Localization;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Category::where('deleted', Base::NO_DELETED)->orderByDesc('created_at')
            ->paginate($this->_limit);
        return view('admin.category.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create')->with([
            'model' => new Category()
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
        $model = new Category();
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

        return redirect()->route('category.index');
    }   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Category::findOrFail($id);

        return view('admin.category.edit')->with([
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
        
        $model = Category::findOrFail($id);
        $model->translateOrNew($this->_lang)->name = $request->input('name');
        $model->order_no = $request->input('order_no');
        $model->status = Base::activeOn($request->input("status"));;
        $model->save();

        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Category::findOrFail($id);
        $model->makeDeleted();

        return redirect()->route('category.index');
    }
}

