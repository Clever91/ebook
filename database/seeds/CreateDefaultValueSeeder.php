<?php

use App\Models\Category;
use App\User;
use Illuminate\Database\Seeder;

class CreateDefaultValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultLang = config('app.locale');
        $admin = User::where('is_admin', 1)->first();
        
        // create default category
        $category = new Category();
        foreach(config('translatable.locales') as $locale) {
            $category->translateOrNew($locale)->name = "Другие - " . $locale;
            $category->translateOrNew($locale)->is_default = 0;
            if ($defaultLang == $locale)
                $category->translateOrNew($locale)->is_default = 1;
        }
        $category->order_no = 1000;
        $category->status = Category::STATUS_ACTIVE;
        $category->created_by = $admin->id;
        $category->save();
    }
}
