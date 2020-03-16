<?php

use App\Models\Group;
use App\Models\GroupProduct;
use App\Models\Product;
use App\User;
use Illuminate\Database\Seeder;

class RelatedGroupToProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $limit = 10;
        $admin = User::where('is_admin', 1)->first();
        $groups = Group::where('status', Group::STATUS_ACTIVE)->take(5)->get();
        
        foreach($groups as $index => $group) {
            $products = Product::where('status', Product::STATUS_ACTIVE)
                ->take($limit)->skip($index * $limit)->get();
            foreach($products as $index2 => $product) {
                GroupProduct::create([
                    'product_id' => $product->id,
                    'group_id' => $group->id,
                    'order_no' => ++$index2,
                    'created_by' => $admin->id
                ]);
            }
        }
    }
}
