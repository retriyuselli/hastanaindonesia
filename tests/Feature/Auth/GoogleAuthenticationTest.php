<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as GoogleUser;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class GoogleAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_offers_google_authentication(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Masuk dengan Google')
            ->assertSee('googleLoginComingSoon');
    }

    public function test_existing_active_user_can_login_with_verified_google_email(): void
    {
        $user = User::factory()->create([
            'email' => 'member@example.com',
            'status' => 'active',
        ]);

        $this->fakeGoogleUser('MEMBER@example.com');

        $response = $this->get(route('auth.google.callback'));

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_google_login_does_not_create_an_unknown_user(): void
    {
        $this->fakeGoogleUser('unknown@example.com');

        $response = $this->get(route('auth.google.callback'));

        $this->assertGuest();
        $this->assertDatabaseCount('users', 0);
        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
    }

    public function test_google_login_rejects_an_unverified_email(): void
    {
        User::factory()->create([
            'email' => 'member@example.com',
            'status' => 'active',
        ]);

        $this->fakeGoogleUser('member@example.com', verified: false);

        $response = $this->get(route('auth.google.callback'));

        $this->assertGuest();
        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
    }

    public function test_google_login_rejects_inactive_users(): void
    {
        User::factory()->create([
            'email' => 'inactive@example.com',
            'status' => 'inactive',
        ]);

        $this->fakeGoogleUser('inactive@example.com');

        $this->get(route('auth.google.callback'))
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_google_login_rejects_users_without_admin_access_for_admin_destination(): void
    {
        User::factory()->create([
            'email' => 'member@example.com',
            'status' => 'active',
        ]);

        $this->fakeGoogleUser('member@example.com');

        $this->withSession(['url.intended' => url('/admin')])
            ->get(route('auth.google.callback'))
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_google_login_preserves_admin_destination_for_an_authorized_user(): void
    {
        $adminRole = Role::findOrCreate('admin');
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'status' => 'active',
        ]);
        $user->assignRole($adminRole);

        $this->fakeGoogleUser('admin@example.com');

        $response = $this->withSession(['url.intended' => url('/admin')])
            ->get(route('auth.google.callback'));

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(url('/admin'));
    }

    private function fakeGoogleUser(string $email, bool $verified = true): void
    {
        Socialite::fake('google', GoogleUser::fake([
            'email' => $email,
            'verified_email' => $verified,
        ]));
    }
}
