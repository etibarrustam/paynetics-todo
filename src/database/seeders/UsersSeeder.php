<?php

namespace Database\Seeders;

use App\Models\Enums\UserRole;
use App\Models\User;
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

            $client->assignRole(UserRole::USER->value);
        }
    }
}
