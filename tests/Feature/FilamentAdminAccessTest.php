<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class FilamentAdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_redirected_to_filament_login(): void
    {
        $response = $this->get('/admin');

        $response->assertStatus(302);
        $this->assertStringContainsString('/login', (string) $response->headers->get('Location'));
    }

    public function test_user_without_panel_role_cannot_access_admin_panel(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(403);
    }

    public function test_user_with_panel_user_role_can_access_admin_panel(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $panelUserRole = config('filament-shield.panel_user.name', 'panel_user');

        Role::findOrCreate($panelUserRole);

        /** @var User $user */
        $user = User::factory()->create();
        $user->assignRole($panelUserRole);

        $response = $this->actingAs($user)->get('/admin');

        $this->assertNotEquals(403, $response->getStatusCode());
        if ($response->getStatusCode() === 302) {
            $this->assertStringNotContainsString('/admin/login', (string) $response->headers->get('Location'));
        }
    }
}
