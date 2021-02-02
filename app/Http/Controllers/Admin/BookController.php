<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Book;
use App\Models\Admin\Image;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends BaseController
{
    public function list(Request $request)
    {
        $books = Book::where([
            'deleted' => Book::NO_DELETED,
        ])->paginate($this->_limit);
        return view('admin.book.list')->with([
            'books' => $books,
        ]);
    }

    public function index(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);
        $books = Book::where([
            'product_id' => $product->id,
            'deleted' => Book::NO_DELETED,
        ])->paginate($this->_limit);
        return view('admin.book.index')->with([
            'product' => $product,
            'books' => $books,
        ]);
    }

    public function add(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);
        return view('admin.book.add', compact('product'));
    }

    public function store(Request $request, $product_id)
    {
        $attributes = $request->validate([
            'name' => 'required|min:3',
            'cover_type_id' => 'required',
            'price' => 'required',
        ]);

        $model = Product::findOrFail($product_id);

        // update product
        $book = new Book();
        $book->product_id = $model->id;
        $book->price = (float) $request->input('price', 0);
        $book->status = Product::STATUS_ACTIVE;
        $book->leftover = $request->input('leftover', null);
        $book->cover_type_id = $request->input('cover_type_id');
        $book->letter = $request->input('letter', null);
        $book->paper_size = $request->input('paper_size', null);
        $book->color_id = $request->input('color_id', null);
        $book->created_by = Auth::user()->id;
        if ($book->save()) {
            return redirect()->route('product.index');
        }
        return back();
    }

    public function edit(Request $request, $id)
    {
        $model = Book::findOrFail($id);
        return view('admin.book.edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $attributes = $request->validate([
            'name' => 'required|min:3',
            'cover_type_id' => 'required',
            'price' => 'required',
        ]);

        $book = Book::findOrFail($id);
        $book->price = (float) $request->input('price', 0);
        $book->status = Product::STATUS_ACTIVE;
        $book->leftover = $request->input('leftover', null);
        $book->cover_type_id = $request->input('cover_type_id');
        $book->letter = $request->input('letter', null);
        $book->paper_size = $request->input('paper_size', null);
        $book->color_id = $request->input('color_id', null);
        $book->updated_by = Auth::user()->id;
        if ($book->save()) {
            return redirect()->route('admin.book.index', $book->product->id);
        }
        return back();
    }

    public function destroy($id)
    {
        $model = Book::findOrFail($id);
        $model->makeDeleted();

        return redirect()->route('admin.book.index', $model->product_id);
    }

    public function image(Request $request, $id)
    {
        $model = Book::findOrFail($id);

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
                $path = Image::getPublicFolder(Image::TYPE_BOOK);
                (new Image)->mkdirFolder($path);

                // generate filename
                $imagename = $model->generateFilename($upload->extension());
                $upload->move($path, $imagename);

                // save new image
                $image = new Image();
                $image->name = $imagename;
                $image->type = Image::TYPE_BOOK;
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

            // return redirect()->route('admin.book.list');
            return redirect()->back();
        }

        return view('admin.book.image')->with([
            'model' => $model
        ]);
    }
}
