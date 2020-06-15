<?php

namespace App\Http\Controllers\Admin;

use App\Models\Base;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Category::orderByDesc('created_at')->paginate($this->_limit);
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
            'status' => 'required',
        ]);
        
        $attributes["status"] = Base::activeOn($request->input("status"));
        $attributes["is_default"] = Base::isDefaultOn($request->input("is_default"));
        $attributes["created_by"] = Auth::user()->id;

        $model = Category::create($attributes);

        return redirect()->route('category.index');
    }   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            'username' => 'required',
            'password' => 'required|min:5',
            'active' => 'required',
            'role' => 'required',
        ]);
        
        $attributes["active"] = $request->input("active") == "on" ? User::STATUS_ACTIVE : User::STATUS_NO_ACTIVE;
        $attributes["password"] = Hash::make($attributes["password"]);
        
        $model = User::findOrFail($id);
        $model->update($attributes);

        if (!is_null($model)) {
            Session::flash('message', __('app.added_successfully')); 
            Session::flash('alert-class', 'alert-success'); 
        }

        return redirect()->route('user.index');
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

        return ['status' => true];
        // return redirect()->route('user.index');
    }
}

