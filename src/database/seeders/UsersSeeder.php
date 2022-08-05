<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Hash;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        User::truncate();

        foreach (range(1, 5) as $clientIndex) {
            $client = User::firstOrCreate(
                [
                    'name' => "Client $clientIndex",
                    'email' => "client$clientIndex@gmail.com",
                    'password' => Hash::make("ClientPassword!$clientIndex")
                ],
            );

            $client->assignRole(UserRole::CLIENT->value);
        }

        foreach (range(1, 5) as $clientIndex) {
            $client = User::firstOrCreate(
                [
                    'name' => "Project manager $clientIndex",
                    'email' => "pm$clientIndex@gmail.com",
                    'password' => Hash::make("PmPassword!$clientIndex")
                ],
            );

            $client->assignRole(UserRole::PROJECT_MANAGER->value);
        }

        foreach (range(1, 25) as $clientIndex) {
            $client = User::firstOrCreate(
                [
                    'name' => "Employee $clientIndex",
                    'email' => "employee$clientIndex@gmail.com",
                    'password' => Hash::make("EmployeePassword!$clientIndex")
                ],
            );

            $client->assignRole(UserRole::EMPLOYEE->value);
        }
    }
}
