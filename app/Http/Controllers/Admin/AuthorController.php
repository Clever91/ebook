<?php

namespace App\Http\Controllers\Admin;

use App\Models\Author;
use App\Models\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lunaweb\Localization\Facades\Localization;

class AuthorController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Author::where('deleted', Base::NO_DELETED)->orderByDesc('created_at')
            ->paginate($this->_limit);
        return view('admin.author.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.author.create')->with([
            'model' => new Author()
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
            'bio' => 'required',
        ]);
        
        // create default category
        $model = new Author();
        $model->name = $request->input('name');
        $model->bio = $request->input('bio');
        $model->status = Base::activeOn($request->input("status"));;
        $model->created_by = Auth::user()->id;
        $model->save();

        return redirect()->route('author.index');
    }   
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Author::findOrFail($id);

        return view('admin.author.edit')->with([
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
            'bio' => 'required',
        ]);

        
        $model = Author::findOrFail($id);
        $model->name = $request->input('name');
        $model->bio = $request->input('bio');
        $model->status = Base::activeOn($request->input("status"));
        $model->save();

        return redirect()->route('author.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Author::findOrFail($id);
        $model->makeDeleted();

        return redirect()->route('author.index');
    }
}