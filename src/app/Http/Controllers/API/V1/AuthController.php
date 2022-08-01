<?php

namespace App\Http\Controllers\API\V1;

use App\Exceptions\UserRoleDoesntExistException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Http\Resources\Auth\AuthTokenResource;
use App\Http\Responses\ApiResponse;
use App\Http\Responses\HasJsonResponse;
use App\Services\AuthService;
use Auth;
use Throwable;

class AuthController extends Controller
{
    use HasJsonResponse;

    /**
     * @var AuthService
     */
    private AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function register(string $type, AuthRegisterRequest $request): ApiResponse
    {
        try {
            $user = $this->service->create(
                $type,
                $request->safe(['name', 'email', 'password']),
            );
        } catch (UserRoleDoesntExistException $e) {
            return $this->failResponse([
                'type' => __('auth.type_is_not_correct')
            ]);
        } catch (Throwable $e) {
            return $this->serviceUnavailable();
        }

        return $this->successResponse(AuthResource::make($user));
    }

    public function login(AuthLoginRequest $request): ApiResponse
    {
        if (
            Auth::guard('web')->attempt($request->safe(['email', 'password'])) &&
            $user = Auth::guard('web')->user()
        ) {
            $user->access_token = $user->createToken('access_token')->plainTextToken;

            return $this->successResponse(AuthTokenResource::make($user));
        }

        return $this->failResponse([
            'email' => __('auth.failed')
        ]);
    }

    public function logout(): ApiResponse
    {
        Auth::user()->tokens()->delete();

        return $this->successResponse();
    }
}
