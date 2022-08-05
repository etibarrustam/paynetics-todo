<?php

namespace Database\Seeders;

use App\Models\Company\Company;
use App\Models\Project\Project;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class CompanyProjectsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $clients = User::role(UserRole::CLIENT->value)->get();

        Company::truncate();
        Project::truncate();
        foreach ($clients as $client) {
            $company = Company::factory()->withClient($client)->create();
            Project::factory()->withProjectable($company)->create();
        }
    }
}
