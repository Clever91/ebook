<?php

use App\Models\Admin\Book;
use App\Models\Admin\PriceType;
use App\Models\Admin\ProductPrice;
use App\Models\Helpers\Base;
use App\User;
use Illuminate\Database\Seeder;

class BasePriceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::where('is_admin', 1)->first();
        $priceType = PriceType::create([
            'name' => "Базовый тип цены",
            'status' => Base::STATUS_ACTIVE,
            'created_by' => $admin->id,
        ]);
        if (!is_null($priceType)) {
            // set price type
            $books = Book::where([
                'status' => Base::STATUS_ACTIVE,
                'deleted' => Base::NO_DELETED
            ])->get();
            if ($books->count()) {
                foreach($books as $book) {
                    ProductPrice::create([
                        'price_type_id' => $priceType->id,
                        'object_id' => $book->id,
                        'object_type' => ProductPrice::TYPE_BOOK,
                        'price' => $book->price,
                        'status' => Base::STATUS_ACTIVE,
                        'created_by' => $admin->id
                    ]);
                }
            }
        }
    }
}
