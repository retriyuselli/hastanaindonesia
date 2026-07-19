<?php

namespace Tests\Feature;

use App\Models\User;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PrivilegeEscalationProtectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_with_permissions_cannot_manage_users_or_roles(): void
    {
        Permission::findOrCreate('Update:User');
        Permission::findOrCreate('Update:Role');
        $this->seed(RoleSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $target = User::factory()->create();
        $role = Role::findByName('member');

        $this->assertTrue($admin->can('Update:User'));
        $this->assertTrue($admin->can('Update:Role'));
        $this->assertFalse(app(UserPolicy::class)->create($admin));
        $this->assertFalse(app(UserPolicy::class)->update($admin, $target));
        $this->assertFalse(app(RolePolicy::class)->viewAny($admin));
        $this->assertFalse(app(RolePolicy::class)->update($admin, $role));
        $this->assertFalse(Gate::forUser($admin)->allows('update', $target));
        $this->assertFalse(Gate::forUser($admin)->allows('update', $role));
    }

    public function test_super_admin_can_manage_users_and_roles_but_protected_records_cannot_be_deleted(): void
    {
        $this->seed(RoleSeeder::class);

        $superAdmin = User::factory()->create();
        $superAdmin->assignRole(config('filament-shield.super_admin.name', 'super_admin'));
        $target = User::factory()->create();
        $superAdminRole = Role::findByName(
            config('filament-shield.super_admin.name', 'super_admin'),
        );

        $userPolicy = app(UserPolicy::class);
        $rolePolicy = app(RolePolicy::class);

        $this->assertTrue($userPolicy->create($superAdmin));
        $this->assertTrue($userPolicy->update($superAdmin, $target));
        $this->assertFalse($userPolicy->delete($superAdmin, $superAdmin));
        $this->assertTrue($rolePolicy->viewAny($superAdmin));
        $this->assertFalse($rolePolicy->delete($superAdmin, $superAdminRole));
    }
}
