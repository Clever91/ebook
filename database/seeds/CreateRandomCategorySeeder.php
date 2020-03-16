<?php

use App\Models\Category;
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
        }
    }
}
