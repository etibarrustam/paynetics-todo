<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (UserRole::cases() as $role) {
            Role::findOrCreate($role->value)
                ->givePermissionTo($this->createPermissions(config("roles.$role->value")));
        }
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
            $permissions[] = Permission::findOrCreate($permission);
        }

        return $permissions;
    }
}
