<?php

namespace Database\Factories\Project;

use App\Models\Project\Project;
use App\Models\Project\ProjectStatus;
use App\Models\User;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

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
        $client = User::factory()->create();
        $client->assignRole([UserRole::CLIENT->value]);

        return [
            'name' => fake()->company(),
            'description' => fake()->text(),
            'status' => ProjectStatus::NEW,
            'projectable_id' => $client,
            'projectable_type' => User::class,
        ];
    }

    /**
     * Add specific Company relation.
     * @param Model $projectable
     * @return static
     */
    public function withProjectable(Model $projectable): static
    {
        return $this->state([
            'projectable_id' => $projectable,
            'projectable_type' => get_class($projectable),
        ]);
    }
}
