<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResetUserMultiFactorAuthenticationCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_resets_mfa_secret_and_recovery_codes(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
        ]);
        $user->saveAppAuthenticationSecret('JBSWY3DPEHPK3PXP');
        $user->saveAppAuthenticationRecoveryCodes(['aaaa-bbbb', 'cccc-dddd']);

        $this->artisan('hastana:reset-mfa', [
            'email' => 'admin@example.com',
            '--force' => true,
        ])->assertSuccessful();

        $user->refresh();

        $this->assertNull($user->getAppAuthenticationSecret());
        $this->assertNull($user->getAppAuthenticationRecoveryCodes());
    }
}
