<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class LogViewerAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_log_viewer_requires_authentication(): void
    {
        $this->get('/admin/log-viewer')
            ->assertRedirect(route('login'));
    }

    public function test_only_super_admin_can_access_log_viewer(): void
    {
        $admin = $this->userWithRole('admin');

        $this->actingAs($admin)
            ->get('/admin/log-viewer')
            ->assertForbidden();

        $superAdmin = $this->userWithRole(
            config('filament-shield.super_admin.name', 'super_admin'),
        );

        $this->actingAs($superAdmin)
            ->get('/admin/log-viewer')
            ->assertOk();
    }

    public function test_log_deletion_is_disabled(): void
    {
        $superAdmin = $this->userWithRole(
            config('filament-shield.super_admin.name', 'super_admin'),
        );

        $this->actingAs($superAdmin);

        $this->assertFalse(Gate::allows('deleteLogFile'));
        $this->assertFalse(Gate::allows('deleteLogFolder'));
    }

    private function userWithRole(string $roleName): User
    {
        $role = Role::findOrCreate($roleName);
        $user = User::factory()->create(['status' => 'active']);
        $user->assignRole($role);

        return $user;
    }
}
