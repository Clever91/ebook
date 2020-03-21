<?php

use App\Models\Author;
use App\Models\Product;
use App\User;
use Illuminate\Database\Seeder;

class CreateRandomAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $admin = User::where('is_admin', 1)->first();

        foreach (range(1, 20) as $index) {
            $author = new Author();
            $author->name = $faker->firstName() . " " . $faker->lastName();
            $author->bio = $faker->paragraph();
            $author->status = Author::STATUS_ACTIVE;
            $author->created_by = $admin->id;
            $author->save();

            // change product author
            $products = Product::take(10)->skip(($index-1) * 10)->get();
            if ($products->count() > 0) {
                foreach($products as $product) {
                    $product->author_id = $author->id;
                    $product->save();
                }
            }
        }
    }
}
