<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // must be default values
        $this->call(CreateAdminUserSeeder::class);
        $this->call(CreateDefaultValueSeeder::class);

        // random params
        $this->call(CreateRandomProductSeeder::class);
        $this->call(CreateRandomCategorySeeder::class);
        $this->call(CreateRandomGroupSeeder::class);
        $this->call(RelatedGroupToProductSeeder::class);
        $this->call(RelatedGroupToCategorySeeder::class);
        $this->call(CreateRandomAuthorSeeder::class);
    }
}
