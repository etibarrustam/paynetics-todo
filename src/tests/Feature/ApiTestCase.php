<?php

namespace Tests\Feature;

use App\Http\Responses\ApiCode;
use App\Models\Enums\UserRole;
use App\Models\User;
use Database\Seeders\RolePermissionsSeeder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class ApiTestCase extends TestCase
{
    protected Authenticatable $user;

    public function getSuccessResponse(array $data = []): array
    {
        return [
            'code' => ApiCode::SUCCESS->value,
            'data' => $data ?: null,
            'validation_errors' => []
        ];
    }

    public function getSuccessResponsePagination(
        array $data = [],
        string $url = '',
        int $total = 20,
        int $perPage = 20
    ): array
    {
        return array_merge(
            (new LengthAwarePaginator($data, $total, $perPage))->setPath($url)->toArray(),
            $this->getSuccessResponse($data)
        );
    }

    public function getFailResponse(array $errors = []): array
    {
        return [
            'code' => ApiCode::ERROR->value,
            'data' => null,
            'validation_errors' => $errors
        ];
    }

    protected function loginUser(UserRole $role): void
    {
        $this->user = User::factory()->create();
        $this->user->assignRole([$role->value]);

        Sanctum::actingAs($this->user, config('roles.' . UserRole::USER->value));
    }

    protected function seedRoleAndPermissions(): void
    {
        $this->seed(RolePermissionsSeeder::class);
        $this->app->make(PermissionRegistrar::class)->registerPermissions();
    }
}
