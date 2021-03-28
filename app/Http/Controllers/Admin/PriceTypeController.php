<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\PriceType;
use App\Models\Helpers\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PriceTypeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = PriceType::orderByDesc('created_at')
            ->paginate($this->_limit);
        return view('admin.priceType.index', compact('models'));
    }

    public function create()
    {
        return view('admin.priceType.create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|min:3',
            // 'status' => 'required',
        ]);

        $model = new PriceType();
        $model->name = $request->input('name');
        $model->status = Base::activeOn($request->input("status"));;
        $model->created_by = Auth::user()->id;
        if ($model->save()) {
            return redirect()->route('admin.priceType.index');
        }
        return back();
    }

    public function edit(Request $request, $id)
    {
        $model = PriceType::findOrFail($id);
        return view('admin.priceType.edit', ['model' => $model]);
    }

    public function update(Request $request, $id)
    {
        $attributes = $request->validate([
            'name' => 'required|min:3',
            // 'status' => 'required',
        ]);

        $model = PriceType::findOrFail($id);
        $model->name = $request->input('name');
        $model->status = Base::activeOn($request->input("status"));
        $model->updated_by = Auth::user()->id;
        if ($model->save()) {
            return redirect()->route('admin.priceType.index');
        }
        return back();
    }

    public function destroy($id)
    {
        $model = PriceType::findOrFail($id);
        // $model->makeDeleted();
        return redirect()->route('admin.priceType.index');
    }
}
