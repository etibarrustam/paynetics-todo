<?php

namespace Database\Factories\Task;

use App\Models\Enums\TaskStatus;
use App\Models\Project\Project;
use App\Models\Task\Task;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory  extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = TaskStatus::toArray();
        return [
            'name' => fake()->jobTitle,
            'project_id' => Project::factory()->create(),
            'description' => fake()->realText,
            'status' => TaskStatus::from($statuses[array_rand($statuses)]),
            'start_at' => Carbon::now()->addDay()->toDateString(),
            'end_at' => Carbon::now()->addDays(5)->toDateString()
        ];
    }

    /**
     * Add specific Task Status relation.
     * @param TaskStatus $status
     * @return static
     */
    public function withStatus(TaskStatus $status): static
    {
        return $this->state([
            'status' => $status,
        ]);
    }

    /**
     * Add specific Project.
     * @param Project $project
     * @return static
     */
    public function withProject(Project $project): static
    {
        return $this->state([
            'project_id' => $project,
        ]);
    }
}
