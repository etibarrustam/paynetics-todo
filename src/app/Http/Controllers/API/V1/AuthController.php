<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Hash;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request)
    {
        $user = User::create(
            array_merge(
                $request->safe(['name', 'email']),
                ['password' => Hash::make($request->safe()->offsetGet('password'))]
            )
        );

        return new ApiResponse($user->toArray());
    }

    public function login()
    {}
}
