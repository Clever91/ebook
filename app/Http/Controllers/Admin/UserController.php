<?php

namespace App\Http\Controllers\Admin;

use App\Models\Helpers\Base;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = User::where('is_admin', User::NO_ADMIN)->paginate($this->_limit);
        return view('admin.user.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create')->with([
            'model' => new User()
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
            'username' => 'required|unique:users',
            'password' => 'required|min:5',
            'role' => 'required',
        ]);

        $attributes["active"] =  Base::activeOn($request->input("active"));
        $attributes["password"] = Hash::make($attributes["password"]);

        $model = User::create($attributes);

        return redirect()->route('user.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = User::findOrFail($id);

        return view('admin.user.edit')->with([
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
            'role' => 'required',
        ]);

        $attributes["active"] = $request->input("active") == "on" ? User::STATUS_ACTIVE : User::STATUS_NO_ACTIVE;
        $attributes["password"] = Hash::make($attributes["password"]);

        $model = User::findOrFail($id);
        $model->update($attributes);

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
        $model = User::findOrFail($id);
        $model->makeDeleted();

        return ['status' => true];
        // return redirect()->route('user.index');
    }
}
