<?php

use App\Models\Author;
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

        // create default author
        Author::create([
            'name' => "Народное",
            'bio' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                when an unknown printer took a galley of type and scrambled it to make a type 
                specimen book. It has survived not only five centuries, but also the leap into 
                electronic typesetting, remaining essentially unchanged. It was popularised 
                in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, 
                and more recently with desktop publishing software like Aldus PageMaker including 
                versions of Lorem Ipsum.",
            'status' => Author::STATUS_ACTIVE,
            'created_by' => $admin->id
        ]);
    }
}
