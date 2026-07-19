<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\AbstractUser;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthenticationController extends Controller
{
    public function redirect(): RedirectResponse
    {
        if (blank(config('services.google.client_id')) || blank(config('services.google.client_secret'))) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Login Google belum dikonfigurasi oleh administrator.']);
        }

        return Socialite::driver('google')
            ->scopes(['openid', 'email', 'profile'])
            ->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $exception) {
            report($exception);

            return $this->failed('Autentikasi Google gagal atau dibatalkan. Silakan coba kembali.');
        }

        $email = Str::lower(trim((string) $googleUser->getEmail()));

        if (! filter_var($email, FILTER_VALIDATE_EMAIL) || ! $this->hasVerifiedEmail($googleUser)) {
            return $this->failed('Akun Google harus memiliki alamat email yang terverifikasi.');
        }

        $user = User::query()
            ->whereRaw('LOWER(email) = ?', [$email])
            ->first();

        if (! $user || $user->status !== 'active') {
            return $this->failed('Email Google ini belum terdaftar sebagai akun aktif.');
        }

        if ($this->isAdminDestination($request) && ! $user->canAccessPanel(Filament::getPanel('admin'))) {
            return $this->failed('Akun ini tidak memiliki akses ke panel admin.');
        }

        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    private function hasVerifiedEmail(AbstractUser $googleUser): bool
    {
        $verified = data_get($googleUser->user, 'verified_email')
            ?? data_get($googleUser->user, 'email_verified');

        return filter_var($verified, FILTER_VALIDATE_BOOL) === true;
    }

    private function isAdminDestination(Request $request): bool
    {
        $intendedPath = parse_url((string) $request->session()->get('url.intended'), PHP_URL_PATH);
        $adminPath = parse_url(Filament::getPanel('admin')->getUrl(), PHP_URL_PATH);

        if (! is_string($intendedPath) || ! is_string($adminPath)) {
            return false;
        }

        $adminPath = '/'.trim($adminPath, '/');

        return $intendedPath === $adminPath || Str::startsWith($intendedPath, $adminPath.'/');
    }

    private function failed(string $message): RedirectResponse
    {
        return redirect()
            ->route('login')
            ->withErrors(['email' => $message]);
    }
}
