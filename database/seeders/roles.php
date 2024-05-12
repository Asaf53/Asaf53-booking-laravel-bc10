<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class roles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['superadmin', 'admin', 'partner', 'client'];
        foreach ($roles as $role) {
            Role::create(['name' => $role, 'guard_name' => 'web']);
        }

        $models = ['users', 'property'];
        $permissions = ['index', 'show', 'create', 'store', 'edit', 'update', 'delete'];

        foreach ($models as $model) {
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission . ' ' . $model, 'guard_name' => 'web']);
            }
        }

        $roles_permissions = [
            'superadmin' => [
                ['model' => 'property', 'permissions' => ['index', 'show', 'create', 'store', 'edit', 'update', 'delete']],
                ['model' => 'users', 'permissions' => ['index', 'show', 'create', 'store', 'edit', 'update', 'delete']],
            ],
            'admin' => [
                ['model' => 'users', 'permissions' => ['index', 'show']],
                ['model' => 'property', 'permissions' => ['index', 'show', 'edit', 'update', 'delete']],
            ],
            'partner' => [
                ['model' => 'property', 'permissions' => ['index', 'show', 'create', 'store', 'edit', 'update', 'delete']],
            ],
            'client' => [
                ['model' => 'property', 'permissions' => ['index', 'show']],
            ],
        ];

        foreach ($roles_permissions as $role => $model_permissions) {
            $role = Role::where('name', $role)->first();
            foreach ($model_permissions as $permissions_set) {
                foreach ($permissions_set['permissions'] as $permission) {
                    $role->givePermissionTo(Permission::where('name', $permission . ' ' . $permissions_set['model'])->first());
                }
            }
        }
    }
}
