<?php

namespace Database\Factories\Project;

use App\Models\Company\Company;
use App\Models\Project\ProjectStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project\Project>
 */
class ProjectFactory  extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->company(),
            'description' => fake()->text(),
            'status' => ProjectStatus::NEW->value,
            'duration' => Carbon::now()->addDays(10),
            'company_id' => Company::factory()->create()
        ];
    }

    /**
     * Add specific Company relation.
     * @param Company $company
     * @return static
     */
    public function withCompany(Company $company): static
    {
        return $this->state([
            'company_id' => $company,
        ]);
    }
}
