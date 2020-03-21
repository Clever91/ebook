<?php

use App\Models\Category;
use App\Models\Product;
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
        $faker = Faker\Factory::create();

        foreach (range(1, 50) as $index) {
            Product::create([
                'category_id' => $category->id,
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
                'price' => $faker->randomFloat(null, 10000, 99000),
                'eprice' => $faker->randomFloat(null, 1000, 10000),
                'ebook' => Product::HAS_EBOOK,
                'status' => Product::STATUS_ACTIVE,
                'created_by' => $admin->id,
            ]);
        }
    }
}
