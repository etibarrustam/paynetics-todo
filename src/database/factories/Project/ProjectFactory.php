<?php

namespace Database\Factories\Project;

use App\Models\Enums\ProjectStatus;
use App\Models\Enums\UserRole;
use App\Models\Project\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory  extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        $user->assignRole([UserRole::USER->value]);
        $statuses = ProjectStatus::toArray();

        return [
            'name' => fake()->company(),
            'user_id' => $user,
            'description' => fake()->text(),
            'status' => ProjectStatus::from($statuses[array_rand($statuses)]),
            'company_name' => fake()->company,
            'company_address' => fake()->address,
        ];
    }

    /**
     * Add specific Company relation.
     * @param User $user
     * @return static
     */
    public function withUser(User $user): static
    {
        return $this->state([
            'user_id' => $user,
        ]);
    }
}
