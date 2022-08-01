<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Tests\Feature\ApiTestCase;

class AuthControllerTest extends ApiTestCase
{
    public function testRegisterUserShouldReturnSuccess()
    {
        $user = User::factory()->create();

        $userRequestData = $this->userRequestData();

        $this->postJson(
            route('api.v1.auth.register'),
            $userRequestData
        )->assertOk()->assertJsonStructure(array_keys($this->getSuccessResponse()))
            ->assertJsonStructure(['data' => array_keys($user->only('id', 'email', 'name', 'created_at', 'updated_at'))]);
    }

    protected function userRequestData():array
    {
        $password = fake()->password();

        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'password' => $password,
            'password_confirmation' => $password,
        ];
    }
}
