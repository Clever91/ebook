<?php

use App\Models\Category;
use App\Models\Product;
use App\User;
use Illuminate\Database\Seeder;

class CreateRandomCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $defaultLang = config('app.locale');
        $admin = User::where('is_admin', 1)->first();

        foreach (range(1, 20) as $index) {
            $category = new Category();
            foreach(config('translatable.locales') as $locale) {
                $category->translateOrNew($locale)->name = $faker->word() . " - " . $locale;
                $category->translateOrNew($locale)->is_default = 0;
                if ($defaultLang == $locale)
                    $category->translateOrNew($locale)->is_default = 1;
            }
            $category->order_no = $index;
            $category->status = Category::STATUS_ACTIVE;
            $category->created_by = $admin->id;
            $category->save();

            // change product category
            $products = Product::take(10)->skip(($index-1) * 10)->get();
            if ($products->count() > 0) {
                foreach($products as $product) {
                    $product->category_id = $category->id;
                    $product->save();
                }
            }
        }
    }
}
