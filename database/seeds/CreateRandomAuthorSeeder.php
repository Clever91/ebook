<?php

use App\User;
use App\Models\Admin\Author;
use App\Models\Admin\Product;
use Illuminate\Database\Seeder;
use Lunaweb\Localization\Facades\Localization;

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
            $author_name = $faker->firstName() . " " . $faker->lastName();
            $author_bio = $faker->paragraph();
            $author = new Author();
            foreach(Localization::getLocales() as $lang => $label) {
                $author->translateOrNew($lang)->name = $author_name;
                $author->translateorNew($lang)->bio = $author_bio;
                $author->translateOrNew($lang)->is_default = 0;
                if (env("LANG_DEFAULT") == $lang)
                    $author->translateOrNew($lang)->is_default = 1;
            }
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
