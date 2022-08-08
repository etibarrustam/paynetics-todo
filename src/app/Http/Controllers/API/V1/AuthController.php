<?php

namespace App\Http\Controllers\API\V1;

use App\Exceptions\UserRoleDoesntExistException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthLoginRequest as AuthLoginRequestAlias;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Http\Requests\Auth\AuthRegisterRequest as AuthRegisterRequestAlias;
use App\Http\Resources\Auth\AuthResource;
use App\Http\Resources\Auth\AuthTokenResource;
use App\Http\Responses\ApiResponse;
use App\Http\Responses\ApiResponse as ApiResponseAlias;
use App\Http\Responses\HasJsonResponse;
use App\Services\AuthService;
use App\Services\AuthService as AuthServiceAlias;
use Auth;
use Throwable;

class AuthController extends Controller
{
    use HasJsonResponse;

    /**
     * @var AuthService
     */
    private AuthService $service;

    /**
     * @param AuthServiceAlias $service
     */
    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * Register new User 'Client, Employee, Project Manager'.
     * @param AuthRegisterRequestAlias $request
     * @return ApiResponseAlias
     */
    public function register(AuthRegisterRequest $request): ApiResponse
    {
        try {
            $user = $this->service->create(
                $request->safe(['name', 'email', 'password']),
            );
        } catch (UserRoleDoesntExistException $e) {
            return $this->failResponse(['type' => __('auth.type_is_not_correct')]);
        } catch (Throwable $e) {
            return $this->serviceUnavailable();
        }

        return $this->successResponse(AuthResource::make($user));
    }

    /**
     * User sign in method.
     * This method uses the 'Web' guard to check that we have the same record that the user inserted.
     * @param AuthLoginRequestAlias $request
     * @return ApiResponseAlias
     */
    public function login(AuthLoginRequest $request): ApiResponse
    {
        if (
            Auth::guard('web')->attempt($request->safe(['email', 'password'])) &&
            $user = Auth::guard('web')->user()
        ) {
            $user->access_token = $user->createToken('access_token')->plainTextToken;

            return $this->successResponse(AuthTokenResource::make($user));
        }

        return $this->failResponse(['email' => [__('auth.failed')]]);
    }

    /**
     * Admin sign in method.
     * @param AuthLoginRequestAlias $request
     * @return ApiResponseAlias
     */
    public function adminLogin(AuthLoginRequest $request): ApiResponse
    {
        if (
            Auth::guard('web_admin')->attempt($request->safe(['email', 'password'])) &&
            $user = Auth::guard('web_admin')->user()
        ) {
            $user->access_token = $user->createToken('access_token')->plainTextToken;

            return $this->successResponse(AuthTokenResource::make($user));
        }

        return $this->failResponse(['email' => __('auth.failed')]);
    }

    public function check(): ApiResponse
    {
        return $this->successResponse();
    }

    /**
     * User sign out method.
     * @return ApiResponseAlias
     */
    public function logout(): ApiResponse
    {
        Auth::user()->tokens()->delete();

        return $this->successResponse();
    }
}
