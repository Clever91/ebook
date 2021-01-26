<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Models\Admin\Image;
use App\Models\Helpers\Base;
use Illuminate\Support\Facades\Auth;
use Lunaweb\Localization\Facades\Localization;

class GoodsController extends BaseController
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
        $model->status = Base::activeOn($request->input("status"));
        $model->updated_by = Auth::user()->id;
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

    public function image(Request $request, $id)
    {
        $model = Category::findOrFail($id);

        if ($request->isMethod('patch')) {

            if (!$model->hasImage()) {
                $this->validate($request, [
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                ]);
            }

            // check image exists
            if ($request->hasfile('image')) {
                // get image info
                $upload = $request->file('image');
                $size = $upload->getSize();
                $ext = $upload->extension();

                // create folder if not exists
                $path = Image::getPublicFolder(Image::TYPE_CATEGORY);
                (new Image)->mkdirFolder($path);

                // generate filename
                $imagename = $model->generateFilename($upload->extension());
                $upload->move($path, $imagename);

                // save new image
                $image = new Image();
                $image->name = $imagename;
                $image->type = Image::TYPE_CATEGORY;
                $image->orginal_name = $upload->getClientOriginalName();
                $image->size = $size;
                $image->extension = $ext;
                if ($image->save()) {
                    // check if model has already image, so delete it
                    if ($model->hasImage()) {
                        $model->image->deleteImage();
                        $model->image->delete();
                    }

                    // update model
                    $model->image_id = $image->id;
                    $model->save();
                }
            }

            return redirect()->route('category.index');
        }

        return view('admin.category.image')->with([
            'model' => $model
        ]);
    }
}

