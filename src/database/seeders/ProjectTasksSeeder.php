<?php

namespace Database\Seeders;

use App\Models\Enums\UserRole;
use App\Models\Project\Project;
use App\Models\Task\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectTasksSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $users = User::role(UserRole::USER->value)->get();
        Project::truncate();
        Task::truncate();

        foreach ($users as $user) {
            $projects = Project::factory()->withUser($user)->count(50)->create();

            foreach ($projects as $project) {
                Task::factory()->withProject($project)->count(40)->create();
            }
        }
    }
}
