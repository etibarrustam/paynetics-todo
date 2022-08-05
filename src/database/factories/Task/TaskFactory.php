<?php

namespace Database\Factories\Task;

use App\Models\Project\ProjectStatus;
use App\Models\Task\Task;
use App\Models\Task\TaskStatus;
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

        return [
            'name' => fake()->jobTitle,
            'description' => fake()->realText,
            'status' => TaskStatus::TODO,
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now()->addDays(5)
        ];
    }

    /**
     * Add specific Project Status relation.
     * @param TaskStatus $status
     * @return static
     */
    public function withStatus(TaskStatus $status): static
    {
        return $this->state([
            'status' => $status,
        ]);
    }
}
