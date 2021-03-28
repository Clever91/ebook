<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Book;
use App\Models\Admin\PriceType;
use App\Models\Admin\ProductPrice;
use App\Models\Helpers\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PriceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $prices = [];
        $products = [];
        $category = [];
        $priceType = PriceType::findOrFail($id);
        // get products
        $books = Book::where([
            'status' => Base::STATUS_ACTIVE,
            'deleted' => Base::NO_DELETED
        ])->get();
        if ($books->count()) {
            foreach($books as $book) {
                $cat_id = $book->product->category_id;
                $cat_name = $book->product->category->translateorNew($this->_lang)->name;
                $category[$cat_id] = $cat_name;
                $products[$cat_id][$book->id] = $book;
            }
        }
        // collect prices
        $proPrice = ProductPrice::where([
            'price_type_id' => $priceType->id,
            'object_type' => ProductPrice::TYPE_BOOK
        ])->get();
        if ($proPrice->count()) {
            foreach($proPrice as $pro) {
                $prices[$pro->object_id] = $pro->price;
            }
        }

        return view('admin.price.index', [
            'priceType' => $priceType,
            'prices' => $prices,
            'products' => $products,
            'category' => $category,
        ]);
    }

    public function setPrice(Request $request, $id)
    {
        $priceType = PriceType::findOrFail($id);
        $books = $request->input('books');
        $prices = $request->input('prices');
        // dd($request->all());

        if (empty($books)) {
            return back()->withErrors("Книги не должны быть пустыми");
        }

        if (empty($prices)) {
            return back()->withErrors("Стоимость книги должна быть меньше одной книги");
        }

        foreach($books as $index => $book_id) {
            $book = Book::find($book_id);
            $price = (float) $prices[$index];
            // ignore book
            if (is_null($book))
                continue;
            $pricePro = ProductPrice::where([
                'price_type_id' => $priceType->id,
                'object_id' => $book->id,
                'object_type' => ProductPrice::TYPE_BOOK,
                'status' => Base::STATUS_ACTIVE
            ])->first();
            if (is_null($pricePro)) {
                // create new
                $model = ProductPrice::create([
                    'price_type_id' => $priceType->id,
                    'object_id' => $book->id,
                    'object_type' => ProductPrice::TYPE_BOOK,
                    'price' => $price,
                    'status' => Base::STATUS_ACTIVE,
                    'created_by' => Auth::user()->id
                ]);
                if (is_null($model)) {
                    dd($request->all());
                }
            } else {
                $pricePro->price = $price;
                $pricePro->save();
            }
        }
        return redirect()->route('admin.priceType.index');
    }
}
