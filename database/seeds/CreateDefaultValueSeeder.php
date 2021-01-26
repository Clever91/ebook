<?php

use App\User;
use App\Models\Admin\Author;
use App\Models\Admin\Category;
use App\Models\Admin\Files;
use App\Models\Admin\Image;
use App\Models\Admin\Product;
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
        $faker = Faker\Factory::create();

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

        // create default epub file
        $file = new Files();
        $file->name = $faker->word();
        $file->orginal_name = "default_book.epub";
        $file->size = 477980;
        $file->extension = "epub";
        $file->save();

        // create default audio file
        $file = new Files();
        $file->name = $faker->word();
        $file->orginal_name = "default_audio.mp3";
        $file->size = 4077980;
        $file->extension = "mp3";
        $file->save();

        // create default audio file
        $image = new Image();
        $image->name = $faker->word();
        $image->type = Image::TYPE_BOOK;
        $image->orginal_name = "default_image.png";
        $image->size = 477980;
        $image->extension = "png";
        $image->save();
    }
}
