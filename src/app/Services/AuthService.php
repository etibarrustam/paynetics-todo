<?php

namespace App\Services;

use App\Exceptions\UserRoleDoesntExistException;
use App\Http\Repositories\Repository;
use App\Models\User;
use App\Models\UserRole;
use Hash;
use Throwable;

class AuthService
{
    /**
     * Create new user.
     * @throws Throwable
     */
    public function create(string $role, array $data = []): User
    {
        throw_if(in_array($role, UserRole::cases(), true), UserRoleDoesntExistException::Class);

        $authRepository = Repository::make(User::class);

        $user = $authRepository->create(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]
        );

        $user->assignRole($role);

        return $user;
    }
}
