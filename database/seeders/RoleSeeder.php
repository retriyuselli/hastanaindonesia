<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $guardName = config('auth.defaults.guard', 'web');

        $superAdminRole = config('filament-shield.super_admin.name', 'super_admin');
        $panelUserRole = config('filament-shield.panel_user.name', 'panel_user');

        $admin = Role::findOrCreate('admin', $guardName);
        $superAdmin = Role::findOrCreate($superAdminRole, $guardName);

        Role::findOrCreate($panelUserRole, $guardName);
        Role::findOrCreate('member', $guardName);
        Role::findOrCreate('customer', $guardName);

        $permissions = Permission::query()->get();

        if ($permissions->isNotEmpty()) {
            $admin->syncPermissions($permissions);
            $superAdmin->syncPermissions($permissions);
        }
    }
}
