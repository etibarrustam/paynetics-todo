<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Enums\UserRole;
use Hash;
use Illuminate\Database\Seeder;

class AdminsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::truncate();

        $admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make("AdminPassword")
        ]);

        $admin->assignRole(UserRole::ADMIN->value);
    }
}
