<?php

namespace App\Filament\Pages\Auth;

use App\Support\Auth\AdminMultiFactorSession;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Actions\Action;
use Filament\Auth\MultiFactor\Contracts\MultiFactorAuthenticationProvider;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Pages\SimplePage;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Concerns\RestrictsFileUploadsToSchemaComponents;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Features\SupportRedirects\Redirector;

/**
 * @property-read Schema $form
 */
class ChallengeMultiFactorAuthentication extends SimplePage
{
    use RestrictsFileUploadsToSchemaComponents;
    use WithRateLimiting;

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {
        abort_unless(Filament::auth()->check(), 403);

        $user = Filament::auth()->user();

        if (! $this->userHasEnabledMultiFactor($user)) {
            $this->redirect(Filament::getSetUpRequiredMultiFactorAuthenticationUrl());

            return;
        }

        if (AdminMultiFactorSession::isConfirmed($user)) {
            $this->redirectIntended(default: Filament::getUrl());

            return;
        }

        $this->form->fill();
    }

    public function authenticate(): ?Redirector
    {
        $user = Filament::auth()->user();
        abort_unless($user !== null, 403);

        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $rateLimitingKey = 'filament-multi-factor-challenge:'.$user->getAuthIdentifier();

        if (RateLimiter::tooManyAttempts($rateLimitingKey, maxAttempts: 5)) {
            Notification::make()
                ->title(__('filament-panels::auth/pages/login.notifications.throttled.title', [
                    'seconds' => RateLimiter::availableIn($rateLimitingKey),
                    'minutes' => ceil(RateLimiter::availableIn($rateLimitingKey) / 60),
                ]))
                ->danger()
                ->send();

            return null;
        }

        RateLimiter::hit($rateLimitingKey);

        $this->form->validate();

        RateLimiter::clear($rateLimitingKey);
        AdminMultiFactorSession::confirm($user);

        return redirect()->intended(Filament::getUrl());
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components(function (): array {
                $user = Filament::auth()->user();

                return collect(Filament::getMultiFactorAuthenticationProviders())
                    ->filter(fn (MultiFactorAuthenticationProvider $provider): bool => $provider->isEnabled($user))
                    ->map(fn (MultiFactorAuthenticationProvider $provider): Component => Group::make($provider->getChallengeFormComponents($user))
                        ->statePath($provider->getId()))
                    ->values()
                    ->all();
            });
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('authenticate')
                    ->footer([
                        Actions::make($this->getFormActions())
                            ->alignment(Alignment::Center)
                            ->fullWidth(true),
                    ]),
            ]);
    }

    /**
     * @return array<Action>
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('authenticate')
                ->label('Verifikasi')
                ->submit('authenticate'),
            Action::make('logout')
                ->label('Keluar & gunakan akun lain')
                ->color('gray')
                ->link()
                ->action(function (): void {
                    AdminMultiFactorSession::clear();
                    Filament::auth()->logout();
                    session()->invalidate();
                    session()->regenerateToken();

                    $this->redirect(route('login'));
                }),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Verifikasi two-factor authentication';
    }

    public function getHeading(): string|Htmlable|null
    {
        return __('filament-panels::auth/pages/login.multi_factor.heading');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('filament-panels::auth/pages/login.multi_factor.subheading');
    }

    protected function getRateLimitedNotification(TooManyRequestsException $exception): ?Notification
    {
        return Notification::make()
            ->title(__('filament-panels::auth/pages/login.notifications.throttled.title', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => $exception->minutesUntilAvailable,
            ]))
            ->body(array_key_exists('body', __('filament-panels::auth/pages/login.notifications.throttled') ?: [])
                ? __('filament-panels::auth/pages/login.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => $exception->minutesUntilAvailable,
                ])
                : null)
            ->danger();
    }

    private function userHasEnabledMultiFactor(?Authenticatable $user): bool
    {
        if (! $user) {
            return false;
        }

        foreach (Filament::getMultiFactorAuthenticationProviders() as $provider) {
            if ($provider->isEnabled($user)) {
                return true;
            }
        }

        return false;
    }
}
