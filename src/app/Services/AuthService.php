<?php

namespace App\Services;

use App\Models\Enums\UserRole;
use App\Models\User;
use Hash;
use Throwable;

class AuthService
{
    /**
     * Create new user.
     * @throws Throwable
     */
    public function create(array $data = []): User
    {
        $user = User::create(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]
        );

        $user->assignRole(UserRole::USER->value);

        return $user;
    }
}
