<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\CoverType;
use App\Models\Helpers\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lunaweb\Localization\Facades\Localization;

class CoverTypeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = CoverType::orderByDesc('created_at')
            ->paginate($this->_limit);
        return view('admin.coverType.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coverType.create')->with([
            'model' => new CoverType()
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
        ]);

        // create default category
        $model = new CoverType();
        foreach(Localization::getLocales() as $lang => $label) {
            $model->translateOrNew($lang)->name = $request->input('name');
            $model->translateOrNew($lang)->is_default = 0;
            if (env("LANG_DEFAULT") == $lang)
                $model->translateOrNew($lang)->is_default = 1;
        }
        $model->status = Base::activeOn($request->input("status"));;
        $model->created_by = Auth::user()->id;
        $model->save();

        return redirect()->route('coverType.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = CoverType::findOrFail($id);

        return view('admin.coverType.edit')->with([
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
        ]);


        $model = CoverType::findOrFail($id);
        $model->translateorNew($this->_lang)->name = $request->input('name');
        $model->status = Base::activeOn($request->input("status"));
        $model->updated_by = Auth::user()->id;
        $model->save();

        return redirect()->route('coverType.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = CoverType::findOrFail($id);
        // $model->delete();

        return redirect()->route('coverType.index');
    }
}
