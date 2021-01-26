<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Author;
use App\Models\Admin\Book;
use App\Models\Admin\Category;
use App\Models\Admin\Ebook;
use App\Models\Admin\Files;
use App\Models\Admin\Image;
use App\Models\Admin\Product;
use App\Models\Helpers\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $models = Product::where('deleted', Product::NO_DELETED)
            ->orderByDesc('created_at')->paginate($this->_limit);
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
            'status' => Category::STATUS_ACTIVE,
            'deleted' => Category::NO_DELETED
        ])->get();

        $authors = Author::where([
            'status' => Author::STATUS_ACTIVE,
            'deleted' => Author::NO_DELETED
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
        $model->category_id = $request->input('category_id');
        $model->author_id = $request->input('author_id');
        $model->status = Base::activeOn($request->input("status"));;
        $model->created_by = Auth::user()->id;
        if ($model->save()) {
            $book = $model->book();
            if (is_null($book)) {
                $book = new Book();
                $book->product_id = $model->id;
                $book->status = Product::STATUS_ACTIVE;
                $book->leftover = $request->input('leftover', null);
                $book->cover_type_id = $request->input('cover_type_id');
                $book->letter = $request->input('letter', null);
                $book->paper_size = $request->input('paper_size', null);
                $book->color_id = $request->input('color_id', null);
                $book->created_by = Auth::user()->id;
            } else {
                $book->updated_by = Auth::user()->id;
            }
            $book->price = $request->input('price', 0);
            $book->save();
        }

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
            'status' => Category::STATUS_ACTIVE,
            'deleted' => Category::NO_DELETED
        ])->get();

        $authors = Author::where([
            'status' => Author::STATUS_ACTIVE,
            'deleted' => Author::NO_DELETED
        ])->get();

        // dd($model->book());

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
        // dd($request->all());

        // update product
        $model = Product::findOrFail($id);
        $model->translateOrNew($this->_lang)->name = $request->input('name');
        $model->translateOrNew($this->_lang)->description = $request->input('description');
        $model->category_id = $request->input('category_id');
        $model->author_id = $request->input('author_id');
        $model->status = Base::activeOn($request->input("status"));
        $model->updated_by = Auth::user()->id;
        if ($model->save()) {
            $book = $model->book();
            $book->leftover = $request->input('leftover', null);
            $book->cover_type_id = $request->input('cover_type_id');
            $book->letter = $request->input('letter', null);
            $book->paper_size = $request->input('paper_size', null);
            $book->color_id = $request->input('color_id', null);
            $book->price = $request->input('price', 0);
            $book->save();
        }

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
            // set ebook price if exist file exists
            $ebook = $model->ebook();
            if ($request->has('eprice')) {
                if (is_null($ebook)) {
                    $ebook = new Ebook();
                    $ebook->product_id = $model->id;
                    $ebook->created_by = Auth::user()->id;
                } else {
                    $ebook->updated_by = Auth::user()->id;
                }
                $ebook->status = Base::STATUS_ACTIVE;
                $ebook->price = $request->input('eprice');
            }

            // check file exists
            if ($request->hasfile('ebook')) {
                // get file info
                $upload = $request->file('ebook');
                $size = $upload->getSize();
                $ext = $upload->extension();

                // todo: must to check extantion and size image
                // if ($ext != "epub" || $size ?)

                // generate filename
                $filename = $model->generateFilename($upload->extension());
                $upload->move(Files::getPublicFolder(), $filename);

                // save new file
                $file = new Files();
                $file->name = $filename;
                $file->orginal_name = $upload->getClientOriginalName();
                $file->size = $size;
                $file->extension = $ext;
                if ($file->save()) {
                    // check if model has already file, so delete it
                    if (!is_null($ebook->file)) {
                        $ebook->file->deleteFile();
                        $ebook->file->delete();
                    }

                    // update model
                    $ebook->file_id = $file->id;
                }
            }

            // save if file exists
            if ($request->hasfile('ebook') || !is_null($ebook))
                $ebook->save();

            return redirect()->route('product.index');
        }

        return view('admin.product.eform')->with([
            'model' => $model
        ]);
    }

    public function image(Request $request, $id)
    {
        $model = Product::findOrFail($id);

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
                $path = Image::getPublicFolder(Image::TYPE_PRODUCT);
                (new Image)->mkdirFolder($path);

                // generate filename
                $imagename = $model->generateFilename($upload->extension());
                $upload->move($path, $imagename);

                // save new image
                $image = new Image();
                $image->name = $imagename;
                $image->type = Image::TYPE_PRODUCT;
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
                    $image->resizeImage(500, 500);
                }
            }

            return redirect()->route('product.index');
        }

        return view('admin.product.image')->with([
            'model' => $model
        ]);
    }
}
