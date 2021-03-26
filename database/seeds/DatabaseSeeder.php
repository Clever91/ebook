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
        $this->call(CreateDefaultCoverTypes::class);
        $this->call(CreateDefaultColors::class);

        // random params
        $this->call(CreateRandomCategorySeeder::class);
        $this->call(CreateRandomAuthorSeeder::class);
        $this->call(CreateRandomProductSeeder::class);
        $this->call(CreateRandomGroupSeeder::class);
        $this->call(CreateRandomGroupRalationSeeder::class);

        // set price to book
        $this->call(BasePriceTypeSeeder::class);
    }
}
