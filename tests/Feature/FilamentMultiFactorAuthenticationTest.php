<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Filament\Actions\Testing\TestAction;
use Filament\Auth\MultiFactor\App\AppAuthentication;
use Filament\Auth\MultiFactor\Pages\SetUpRequiredMultiFactorAuthentication;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentMultiFactorAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_panel_requires_app_based_multi_factor_authentication(): void
    {
        $panel = Filament::getPanel('admin');

        $this->assertTrue($panel->isMultiFactorAuthenticationRequired());
        $this->assertContainsOnlyInstancesOf(
            AppAuthentication::class,
            $panel->getMultiFactorAuthenticationProviders(),
        );
    }

    public function test_user_model_encrypts_mfa_secrets_and_recovery_codes(): void
    {
        $user = User::factory()->create();
        $user->saveAppAuthenticationSecret('secret-value');
        $user->saveAppAuthenticationRecoveryCodes(['recovery-code']);

        $rawUser = User::query()->whereKey($user)->firstOrFail();

        $this->assertNotSame('secret-value', $rawUser->getRawOriginal('app_authentication_secret'));
        $this->assertStringNotContainsString(
            'recovery-code',
            (string) $rawUser->getRawOriginal('app_authentication_recovery_codes'),
        );
        $this->assertSame('secret-value', $rawUser->getAppAuthenticationSecret());
        $this->assertSame(['recovery-code'], $rawUser->getAppAuthenticationRecoveryCodes());
    }

    public function test_authenticator_setup_action_can_open(): void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();
        $user->assignRole(config('filament-shield.super_admin.name', 'super_admin'));

        Filament::setCurrentPanel(Filament::getPanel('admin'));

        $this->actingAs($user);
        $setUpAction = TestAction::make('setUpAppAuthentication')
            ->schemaComponent('app', schema: 'content');

        Livewire::test(SetUpRequiredMultiFactorAuthentication::class)
            ->mountAction($setUpAction)
            ->assertActionMounted($setUpAction);
    }
}
