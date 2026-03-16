<?php

namespace Tests\Feature\Seeders;

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FilamentShieldSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_filament_shield_seeder_creates_expected_roles(): void
    {
        $this->seed(RoleSeeder::class);

        $guardName = config('auth.defaults.guard', 'web');
        $panelUserRole = config('filament-shield.panel_user.name', 'panel_user');
        $superAdminRole = config('filament-shield.super_admin.name', 'super_admin');

        $this->assertTrue(Role::query()->where('name', 'admin')->where('guard_name', $guardName)->exists());
        $this->assertTrue(Role::query()->where('name', $panelUserRole)->where('guard_name', $guardName)->exists());
        $this->assertTrue(Role::query()->where('name', $superAdminRole)->where('guard_name', $guardName)->exists());
    }

    public function test_admin_user_seeder_assigns_spatie_roles(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(AdminUserSeeder::class);

        $admin = User::query()->where('email', 'admin@hastana.com')->firstOrFail();
        $superAdminEmail = 'superadmin@hastana.com';
        $superAdminRole = config('filament-shield.super_admin.name', 'super_admin');
        $superAdmin = User::query()->where('email', $superAdminEmail)->firstOrFail();

        $this->assertTrue($admin->hasRole('admin'));
        $this->assertTrue($superAdmin->hasRole($superAdminRole));
    }
}
