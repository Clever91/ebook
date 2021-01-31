<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Author;
use App\Models\Admin\Image;
use App\Models\Helpers\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
        $model->translateorNew($this->_lang)->name = $request->input('name');
        $model->translateorNew($this->_lang)->bio = $request->input('bio');
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
        $model->translateorNew($this->_lang)->name = $request->input('name');
        $model->translateorNew($this->_lang)->bio = $request->input('bio');
        $model->status = Base::activeOn($request->input("status"));
        $model->updated_by = Auth::user()->id;
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

    public function image(Request $request, $id)
    {
        $model = Author::findOrFail($id);

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
                $path = Image::getPublicFolder(Image::TYPE_AUTHOR);
                (new Image)->mkdirFolder($path);

                // generate filename
                $imagename = $model->generateFilename($upload->extension());
                $upload->move($path, $imagename);

                // save new image
                $image = new Image();
                $image->name = $imagename;
                $image->type = Image::TYPE_AUTHOR;
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


                    // create thumbnails images
                    // $image->resizeImage(100, 100);
                    // $image->resizeImage(300, 300);
                }
            }

            return redirect()->route('author.index');
        }

        return view('admin.author.image')->with([
            'model' => $model
        ]);
    }
}
