<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return User::create([
            'name' => "Admin",
            'username' => "admin",
            'email' => "sherzod.usmon.91@gmail.com",
            'password' => Hash::make("usmon.91"),
            'is_admin' => 1,
            'role' => User::ROLE_ADMIN, // admin
            'active' => User::STATUS_ACTIVE
        ]);
    }
}
