<?php

namespace Database\Factories\Company;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company\Company>
 */
class CompanyFactory  extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $client = User::factory()->create();
        $client->assignRole(UserRole::CLIENT->value);

        return [
            'name' => fake()->company(),
            'address' => fake()->address(),
            'client_id' => $client
        ];
    }

    /**
     * Add specific Client relation.
     * @param User $client
     * @return static
     */
    public function withClient(User $client): static
    {
        return $this->state([
            'client_id' => $client,
        ]);
    }
}
