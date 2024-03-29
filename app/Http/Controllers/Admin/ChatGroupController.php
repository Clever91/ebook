<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bot\ChatGroup;
use Illuminate\Http\Request;

class ChatGroupController extends Controller
{
    public function index()
    {
        $models = ChatGroup::orderByDesc('id')->paginate(10);
        return view('admin.chatGroup.index', compact('models'));
    }

    public function destroy($id)
    {
        $model = ChatGroup::findOrFail($id);
        $model->delete();

        return redirect()->route('admin.chat.groups');
    }
}
