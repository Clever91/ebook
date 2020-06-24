<?php

namespace App\Http\Controllers\Admin;

use App\Models\Author;
use App\Models\Base;
use App\Models\Category;
use App\Models\Files;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lunaweb\Localization\Facades\Localization;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Product::where('deleted', Base::NO_DELETED)->orderByDesc('created_at')
            ->paginate($this->_limit);
        return view('admin.product.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where([
            'status' => Base::STATUS_ACTIVE,
            'deleted' => Base::NO_DELETED
        ])->get();

        $authors = Author::where([
            'status' => Base::STATUS_ACTIVE,
            'deleted' => Base::NO_DELETED
        ])->get();

        return view('admin.product.create')->with([
            'model' => new Product(),
            'authors' => $authors,
            'categories' => $categories
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
            'description' => 'required',
            'category_id' => 'required',
            'author_id' => 'required',
            'price' => 'required',
        ]);
        
        // create default product
        $model = new Product();
        foreach(Localization::getLocales() as $lang => $item) {
            $model->translateOrNew($lang)->name = $request->input('name');
            $model->translateOrNew($lang)->description = $request->input('description');
            $model->translateOrNew($lang)->is_default = 0;
            if (env("LANG_DEFAULT") == $lang)
                $model->translateOrNew($lang)->is_default = 1;
        }
        $model->ebook = 0;
        $model->price = $request->input('price');
        $model->eprice = $request->input('eprice');
        $model->category_id = $request->input('category_id');
        $model->author_id = $request->input('author_id');
        $model->status = Base::activeOn($request->input("status"));;
        $model->created_by = Auth::user()->id;
        $model->save();

        return redirect()->route('product.index');
    }  
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Product::findOrFail($id);
        $categories = Category::where([
            'status' => Base::STATUS_ACTIVE,
            'deleted' => Base::NO_DELETED
        ])->get();

        $authors = Author::where([
            'status' => Base::STATUS_ACTIVE,
            'deleted' => Base::NO_DELETED
        ])->get();

        return view('admin.product.edit')->with([
            'model' => $model,
            'categories' => $categories,
            'authors' => $authors,
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
            'description' => 'required',
            'category_id' => 'required',
            'author_id' => 'required',
            'price' => 'required',
        ]);

        // update product
        $model = Product::findOrFail($id);
        $model->translateOrNew($this->_lang)->name = $request->input('name');
        $model->translateOrNew($this->_lang)->description = $request->input('description');
        $model->ebook = 0;
        $model->price = $request->input('price');
        $model->eprice = $request->input('eprice');
        $model->category_id = $request->input('category_id');
        $model->author_id = $request->input('author_id');
        $model->status = Base::activeOn($request->input("status"));;
        $model->save();

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Product::findOrFail($id);
        $model->makeDeleted();

        return redirect()->route('product.index');
    }

    public function eform(Request $request, $id)
    {
        $model = Product::findOrFail($id);

        if ($request->isMethod('patch')) {
            // validate
            // $validatedData = $request->validate([
            //     'eprice' => 'required',
            //     'ebook' => 'required|mimes:epub', //|file|mimes:epub|max:10240
            // ]);

            // check file exists
            if ($request->hasfile('ebook')) {
                // get file info
                $upload = $request->file('ebook');
                $size = $upload->getSize();
                $ext = $upload->extension();

                // generate filename
                $filename = $model->generateFilename($upload->extension());  
                $upload->move(Files::getPublicFolder(), $filename);

                // save new file
                $file = new Files();
                $file->name = $filename;
                $file->orginal_name = $upload->getClientOriginalName();
                $file->size = $size;
                $file->extantion = $ext;
                if ($file->save()) {
                    // check if model has already file, so delete it
                    if (!is_null($model->file)) {
                        $model->file->deleteFile();
                        $model->file->delete();
                    }

                    // update model
                    $model->file_id = $file->id;
                    $model->ebook = Product::HAS_EBOOK;
                    $model->eprice = $request->input('eprice');
                    $model->save();
                }
            }

            return redirect()->route('product.index');
        }

        return view('admin.product.eform')->with([
            'model' => $model
        ]);
    }
}
