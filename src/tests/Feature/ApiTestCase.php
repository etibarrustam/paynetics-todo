<?php

namespace Tests\Feature;

use App\Http\Responses\ApiCode;
use App\Models\User;
use App\Models\UserRole;
use Database\Seeders\RolePermissionsSeeder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class ApiTestCase extends TestCase
{
    private Authenticatable $user;

    /**
     */
    public function getSuccessResponse(array $data = []): array
    {
        return [
            'code' => ApiCode::SUCCESS->value,
            'data' => $data ?: null,
            'validation_errors' => []
        ];
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

        $this->actingAs($this->user, 'sanctum');
    }

    protected function seedRoleAndPermissions(): void
    {
        $this->seed(RolePermissionsSeeder::class);
        $this->app->make(PermissionRegistrar::class)->registerPermissions();
    }
}
