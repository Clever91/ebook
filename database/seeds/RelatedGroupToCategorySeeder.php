<?php

use App\Models\Category;
use App\Models\Group;
use App\Models\GroupCategory;
use App\User;
use Illuminate\Database\Seeder;

class RelatedGroupToCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $limit = 6;
        $admin = User::where('is_admin', 1)->first();
        $groups = Group::where('status', Group::STATUS_ACTIVE)->take(3)->skip(5)->get();
        
        foreach($groups as $index => $group) {
            $categories = Category::where('status', Category::STATUS_ACTIVE)
                ->take($limit)->skip($index * $limit)->get();
            foreach($categories as $index2 => $category) {
                GroupCategory::create([
                    'category_id' => $category->id,
                    'group_id' => $group->id,
                    'order_no' => ++$index2,
                    'created_by' => $admin->id
                ]);
            }
        }
    }
}
