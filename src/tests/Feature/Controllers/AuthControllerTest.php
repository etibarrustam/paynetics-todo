<?php

namespace Tests\Feature\Controllers;

use App\Models\Enums\UserRole;
use App\Models\User;
use Hash;
use Tests\Feature\ApiTestCase;

class AuthControllerTest extends ApiTestCase
{
    /**
     * Test User registration method.
     * @return void
     */
    public function testRegisterUser()
    {
        $user = User::factory()->create();
        $userRequestData = $this->userRequestData();

        $response = $this->postJson(
            route('api.v1.auth.register', ['type' => UserRole::USER->value]),
            $userRequestData
        );

        $content = (array)$response->json('data');
        $registeredUser = User::whereEmail($content['email'])->firstOrFail();

        $this->assertContains(UserRole::USER->value, $registeredUser->getRoleNames());

        $response->assertOk()
            ->assertJsonStructure(array_keys($this->getSuccessResponse()))
            ->assertJsonStructure(
                ['data' => array_keys($user->only('email', 'name', 'created_at'))]
            );
    }

    /**
     * Test User login method.
     * @return void
     */
    public function testLoginUser()
    {
        $userRequestData = $this->userRequestData();

        User::factory()->create([
            'email' => $userRequestData['email'],
            'password' => Hash::make($userRequestData['password'])
        ]);

        $this->postJson(
            route('api.v1.auth.login'),
            $userRequestData
        )
            ->assertOk()
            ->assertJsonStructure(array_keys($this->getSuccessResponse()))
            ->assertJsonStructure(
                ['data' => ['token', 'token_type']]
            );
    }

    /**
     * Generate fake User data.
     * @return array
     */
    protected function userRequestData(): array
    {
        $password = "1test@User";

        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'password' => $password,
            'password_confirmation' => $password,
        ];
    }
}
