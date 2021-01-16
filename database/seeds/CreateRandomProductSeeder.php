<?php

use App\Models\Admin\AudioBook;
use App\Models\Admin\Author;
use App\Models\Admin\Book;
use App\Models\Admin\Category;
use App\Models\Admin\Ebook;
use App\Models\Admin\Files;
use App\Models\Admin\Good;
use App\Models\Admin\Product;
use App\User;
use Illuminate\Database\Seeder;

class CreateRandomProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::where('is_admin', 1)->first();
        $category = Category::first();
        $author = Author::first();
        $file_epub = Files::where('extension', 'epub')->first();
        $file_mp3 = Files::where('extension', 'mp3')->first();
        $faker = Faker\Factory::create();

        // create random product
        foreach (range(1, 60) as $index) {
            $product = Product::create([
                'category_id' => $category->id,
                'author_id' => $author->id,
                'en' => [
                    'name' => $faker->word() . " (en)",
                    'description' => $faker->paragraph() . " (en)",
                    'is_default' => 1
                ],
                'ru' => [
                    'name' => $faker->word() . " (ru)",
                    'description' => $faker->paragraph() . " (ru)",
                ],
                'uz' => [
                    'name' => $faker->word() . " (uz)",
                    'description' => $faker->paragraph() . " (uz)",
                ],
                'status' => Product::STATUS_ACTIVE,
                'created_by' => $admin->id,
            ]);

            // create random books
            $book = null;
            if ($index % 10 != 0) {
                $book = Book::create([
                    'product_id' => $product->id,
                    'price' => $faker->randomFloat(null, 10000, 99000),
                    'leftover' => random_int(-1, 5) > 0 ? $faker->numberBetween(10, 90) : null,
                    'cover' => Book::COVER_HARD,
                    'paper_size' => "A5",
                    'letter' => random_int(-1, 1) > 0 ? Book::LETTER_LATIN : Book::LETTER_KRILL,
                    'color' => random_int(-1, 2) == 0 ? Book::COLOR_WHITE : null,
                    'status' => Product::STATUS_ACTIVE,
                    'created_by' => $admin->id,
                ]);
            }

            // create random ebook
            if ($index % 3 == 0 && !is_null($book)) {
                Ebook::create([
                    'product_id' => $product->id,
                    'price' => $faker->randomFloat(null, 2000, 15000),
                    'file_id' => $file_epub->id,
                    'status' => Product::STATUS_ACTIVE,
                    'created_by' => $admin->id,
                ]);
            }

            // create random ebook
            if ($index % 6 == 0 && !is_null($book)) {
                AudioBook::create([
                    'product_id' => $product->id,
                    'price' => $faker->randomFloat(null, 10000, 25000),
                    'file_id' => $file_mp3->id,
                    'status' => Product::STATUS_ACTIVE,
                    'created_by' => $admin->id,
                ]);
            }

            // create random goods
            if (is_null($book)) {
                Good::create([
                    'product_id' => $product->id,
                    'price' => $faker->randomFloat(null, 10000, 80000),
                    'leftover' => random_int(-1, 5) > 0 ? $faker->numberBetween(10, 90) : null,
                    'status' => Product::STATUS_ACTIVE,
                    'created_by' => $admin->id,
                ]);
            }
        }
    }
}
