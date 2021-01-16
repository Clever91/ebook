<?php

use App\Models\Admin\Group;
use App\User;
use Illuminate\Database\Seeder;

class CreateRandomGroupSeeder extends Seeder
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

        foreach (range(1, 10) as $index) {
            $group = new Group();
            foreach(config('translatable.locales') as $locale) {
                $group->translateOrNew($locale)->name = $faker->word() . " - " . $locale;
                $group->translateOrNew($locale)->is_default = 0;
                if ($defaultLang == $locale)
                    $group->translateOrNew($locale)->is_default = 1;
            }
            $group->order_no = $index;
            $group->status = Group::STATUS_ACTIVE;
            $group->created_by = $admin->id;
            $group->save();
        }
    }
}
