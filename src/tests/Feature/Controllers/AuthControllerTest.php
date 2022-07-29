<?php

namespace Tests\Feature\Controllers;

use Tests\Feature\ApiTestCase;

class AuthControllerTest extends ApiTestCase
{
    public function testRegisterUserShouldReturnSuccess()
    {
        $password = fake()->password();

        dd($this->successResponse());
        $response = $this->postJson(
            route('api.v1.auth.register'),
            [
                'name' => fake()->name(),
                'email' => fake()->safeEmail(),
                'password' => $password,
                'password_confirmation' => $password,
            ]
        )->assertOk()->assertJsonFragment($this->successResponse())
//            ->getStatusCode()
        ;

        dd($response);
    }
}
