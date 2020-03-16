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

        // random 
        $this->call(CreateRandomProductSeeder::class);
        $this->call(CreateRandomCategorySeeder::class);
    }
}
