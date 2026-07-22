<?php

namespace Tests\Feature;

use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        $response->assertRedirect(route('admin.access-denied'));
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

    public function test_inactive_or_known_default_password_accounts_cannot_access_production_panel(): void
    {
        $adminRole = Role::findOrCreate('admin');
        $panel = Filament::getPanel('admin');

        $inactiveUser = User::factory()->create(['status' => 'inactive']);
        $inactiveUser->assignRole($adminRole);
        $this->assertFalse($inactiveUser->canAccessPanel($panel));

        $defaultPasswordUser = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);
        $defaultPasswordUser->assignRole($adminRole);

        $originalEnvironment = $this->app['env'];
        $this->app['env'] = 'production';

        try {
            $this->assertFalse($defaultPasswordUser->canAccessPanel($panel));
            $this->assertFalse(Auth::attempt([
                'email' => $defaultPasswordUser->email,
                'password' => 'password123',
            ]));
            $this->assertGuest();
        } finally {
            $this->app['env'] = $originalEnvironment;
        }
    }
}
