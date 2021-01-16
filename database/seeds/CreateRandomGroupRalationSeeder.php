<?php

use App\User;
use App\Models\Admin\Author;
use App\Models\Admin\Category;
use App\Models\Admin\Group;
use App\Models\Admin\GroupRelation;
use App\Models\Admin\Product;
use Illuminate\Database\Seeder;

class CreateRandomGroupRalationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $limit = 5;
        $admin = User::where('is_admin', 1)->first();
        $groups = Group::where('status', Group::STATUS_ACTIVE)->take(15)->skip(0)->get();

        foreach($groups as $index => $group) {

            // create group category relation
            if ($index < 2) {
                $categories = Category::where('status', Category::STATUS_ACTIVE)
                    ->take($limit)->skip($index * $limit)->get();

                if ($categories->count() > 0) {
                    foreach($categories as $index2 => $category) {
                        GroupRelation::create([
                            'related_id' => $category->id,
                            'type' => GroupRelation::TYPE_CATEGORY,
                            'group_id' => $group->id,
                            'order_no' => ($index * 10) + ($index2 + 1),
                            'created_by' => $admin->id
                        ]);
                    }
                }
            }

            // create group author relation
            if ($index == 2) {
                $authors = Author::where('status', Author::STATUS_ACTIVE)
                    ->take($limit)->skip(0)->get();

                if ($authors->count() > 0) {
                    foreach($authors as $index2 => $author) {
                        GroupRelation::create([
                            'related_id' => $author->id,
                            'type' => GroupRelation::TYPE_AUTHOR,
                            'group_id' => $group->id,
                            'order_no' => ($index * 10) + ($index2 + 1),
                            'created_by' => $admin->id
                        ]);
                    }
                }
            }

            // create group product relation
            if (3 <= $index && $index <= 10) {
                $products = Product::where('status', Product::STATUS_ACTIVE)
                    ->take($limit)->skip(($index - 3) * 15)->get();

                if ($products->count() > 0) {
                    foreach($products as $index2 => $product) {
                        GroupRelation::create([
                            'related_id' => $product->id,
                            'type' => GroupRelation::TYPE_PRODUCT,
                            'group_id' => $group->id,
                            'order_no' => ($index2 +1),
                            'created_by' => $admin->id
                        ]);
                    }
                }
            }
        }
    }
}
