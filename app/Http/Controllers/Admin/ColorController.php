<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Color;
use App\Models\Helpers\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColorController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Color::orderByDesc('created_at')->paginate($this->_limit);
        return view('admin.color.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.color.create')->with([
            'model' => new Color()
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
            'short' => 'required',
            'hex' => 'required',
        ]);

        // create default category
        $model = new Color();
        $model->name = $request->input("name");
        $model->short = $request->input("short");
        $model->hex = $request->input("hex");
        $model->status = Base::activeOn($request->input("status"));
        $model->save();

        return redirect()->route('color.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Color::findOrFail($id);

        return view('admin.color.edit')->with([
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
            'short' => 'required',
            'hex' => 'required',
        ]);

        $model = Color::findOrFail($id);
        $model->name = $request->input('name');
        $model->short = $request->input('short');
        $model->hex = $request->input('hex');
        $model->status = Base::activeOn($request->input("status"));
        $model->save();

        return redirect()->route('color.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Color::findOrFail($id);
        // $model->delete();

        return redirect()->route('color.index');
    }
}
