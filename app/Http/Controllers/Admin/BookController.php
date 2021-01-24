<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Book;
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
            'cover' => 'required',
            'letter' => 'required',
            'price' => 'required',
        ]);

        $model = Product::findOrFail($product_id);

        // update product
        $book = new Book();
        $book->product_id = $model->id;
        $book->price = $request->input('price', 0);
        $book->status = Product::STATUS_ACTIVE;
        $book->leftover = $request->input('leftover', null);
        $book->cover = $request->input('cover');
        $book->letter = $request->input('letter');
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
            'cover' => 'required',
            'letter' => 'required',
            'price' => 'required',
        ]);

        $book = Book::findOrFail($id);
        $book->price = $request->input('price', 0);
        $book->status = Product::STATUS_ACTIVE;
        $book->leftover = $request->input('leftover', null);
        $book->cover = $request->input('cover');
        $book->letter = $request->input('letter');
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
}
