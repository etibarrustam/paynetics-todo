<?php

namespace Database\Seeders;

use App\Models\Enums\UserPermission;
use App\Models\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;

class RolePermissionsSeeder extends Seeder
{
    protected const GUARD = 'sanctum';

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->createPermissions(UserPermission::toArray());

        Role::findOrCreate(UserRole::ADMIN->value)
            ->givePermissionTo(config("roles." . UserRole::ADMIN->value));
        Role::findOrCreate(UserRole::USER->value)
                ->givePermissionTo(config("roles." . UserRole::USER->value));

    }

    /**
     * Create Permissions for each Role.
     * @param array $data
     * @return array
     */
    protected function createPermissions(array $data): array
    {
        $permissions = [];

        foreach ($data as $permission) {
            $permissions[] = Permission::findOrCreate($permission, self::GUARD);
        }

        return $permissions;
    }
}
