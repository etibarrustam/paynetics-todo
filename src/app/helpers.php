<?php

use App\Http\Responses\ApiResponse;
use App\Models\Enums\UserPermission;
use App\Models\Enums\UserRole;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

if (!function_exists('apiResponse')) {

    /**
     * @param JsonResource|null $resource
     * @param array $headers
     * @param int $options
     * @return \App\Http\Responses\ApiResponse
     */
    function apiResponse(JsonResource $resource = null, array $headers = [], int $options = 0): ApiResponse
    {
        return new ApiResponse($resource, $headers, $options);
    }
}

if (!function_exists('permissions')) {

    /**
     * @param array<UserPermission> $permissions
     * @param string $methodName
     * @return string
     */
    function setPermissions(array $permissions, string $methodName = 'ability'): string
    {
        $permissionNames = implode(',', array_map('getPermissionName', $permissions));

        return "$methodName:$permissionNames";
    }
}

if (!function_exists('getPermissionName')) {

    /**
     * @param UserPermission $permission
     * @return string
     */
    function getPermissionName(UserPermission $permission): string
    {
        return $permission->value;
    }
}

if (!function_exists('isAdmin')) {

    /**
     * Check if authenticated user is admin.
     * @return bool
     */
    function isAdmin(): bool
    {
        if (!auth()->check()) {
            return false;
        }

        return in_array(UserRole::ADMIN->value, Auth::user()->roles->toArray(), true);
    }
}
