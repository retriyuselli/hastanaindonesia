<?php

namespace Tests\Feature;

use App\Models\User;
use App\Support\Auth\AdminMultiFactorSession;
use Database\Seeders\RoleSeeder;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMultiFactorChallengeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);
        Filament::setCurrentPanel(Filament::getPanel('admin'));
    }

    public function test_admin_with_mfa_enabled_is_challenged_before_accessing_panel(): void
    {
        $user = $this->makeAdminWithMfa();

        $this->actingAs($user)
            ->get('/admin')
            ->assertRedirect(route('filament.admin.auth.multi-factor-authentication.challenge'));
    }

    public function test_admin_can_access_panel_after_mfa_is_confirmed(): void
    {
        $user = $this->makeAdminWithMfa();

        AdminMultiFactorSession::confirm($user);

        $this->actingAs($user)
            ->get('/admin')
            ->assertOk();
    }

    public function test_challenge_page_is_available_when_mfa_is_enabled(): void
    {
        $user = $this->makeAdminWithMfa();

        $this->actingAs($user)
            ->get(route('filament.admin.auth.multi-factor-authentication.challenge'))
            ->assertOk();
    }

    public function test_password_login_clears_previous_mfa_confirmation(): void
    {
        $user = User::factory()->create([
            'email' => 'member@example.com',
            'password' => 'password',
            'status' => 'active',
        ]);

        AdminMultiFactorSession::confirm($user);
        $this->assertTrue(AdminMultiFactorSession::isConfirmed($user));

        $this->post('/login', [
            'email' => 'member@example.com',
            'password' => 'password',
        ])->assertRedirect(route('dashboard', absolute: false));

        $this->assertFalse(AdminMultiFactorSession::isConfirmed($user));
    }

    private function makeAdminWithMfa(): User
    {
        $user = User::factory()->create(['status' => 'active']);
        $user->assignRole(config('filament-shield.super_admin.name', 'super_admin'));
        $user->saveAppAuthenticationSecret('JBSWY3DPEHPK3PXP');

        AdminMultiFactorSession::clear();

        return $user->fresh();
    }
}
