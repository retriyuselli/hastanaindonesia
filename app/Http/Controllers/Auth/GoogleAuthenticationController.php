<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\Auth\AdminMultiFactorSession;
use App\Support\EmailAddress;
use Filament\Facades\Filament;
use Illuminate\Auth\Events\Registered;
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

        $user = EmailAddress::findUser($email);

        if ($user && $user->status !== 'active') {
            return $this->failed('Akun dengan email ini tidak aktif. Silakan hubungi admin HASTANA.');
        }

        $isAdminDestination = $this->isAdminDestination($request);

        if (! $user) {
            if ($isAdminDestination) {
                $request->session()->forget('url.intended');

                return $this->denyAdminAccess(
                    title: 'Akun Belum Terdaftar',
                    message: 'Email Google ini belum terdaftar di HASTANA Indonesia. Silakan daftar terlebih dahulu atau hubungi administrator.',
                );
            }

            $user = $this->registerFromGoogle($googleUser, $email);
        } else {
            $this->syncGoogleAvatar($user, $googleUser);
        }

        if ($isAdminDestination && ! $user->canAccessPanel(Filament::getPanel('admin'))) {
            Auth::guard('web')->login($user);
            $request->session()->regenerate();
            AdminMultiFactorSession::clear();
            $request->session()->forget('url.intended');

            return $this->denyAdminAccess(
                title: 'Akses Panel Admin Ditolak',
                message: 'Email ini sudah terdaftar, tetapi tidak memiliki izin untuk membuka panel admin. Silakan lanjut ke beranda atau dashboard anggota.',
            );
        }

        Auth::guard('web')->login($user);
        $request->session()->regenerate();
        AdminMultiFactorSession::clear();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    private function registerFromGoogle(AbstractUser $googleUser, string $email): User
    {
        $name = trim((string) ($googleUser->getName() ?: $googleUser->getNickname() ?: Str::before($email, '@')));

        $user = User::create([
            'name' => $name !== '' ? $name : $email,
            'email' => $email,
            'password' => Str::password(32),
            'status' => 'active',
            'email_verified_at' => now(),
            'avatar' => $googleUser->getAvatar() ?: null,
        ]);

        event(new Registered($user));

        return $user;
    }

    /**
     * Keep Google photo as default when the user has not uploaded a local avatar.
     */
    private function syncGoogleAvatar(User $user, AbstractUser $googleUser): void
    {
        $googleAvatar = $googleUser->getAvatar();

        if (blank($googleAvatar) || $user->hasStoredAvatar()) {
            return;
        }

        if ($user->avatar === $googleAvatar) {
            return;
        }

        $user->forceFill(['avatar' => $googleAvatar])->save();
    }

    private function hasVerifiedEmail(AbstractUser $googleUser): bool
    {
        $verified = data_get($googleUser->user, 'verified_email')
            ?? data_get($googleUser->user, 'email_verified');

        return filter_var($verified, FILTER_VALIDATE_BOOL) === true;
    }

    private function isAdminDestination(Request $request): bool
    {
        $adminPath = parse_url(Filament::getPanel('admin')->getUrl(), PHP_URL_PATH);
        $adminPath = is_string($adminPath) ? '/'.trim($adminPath, '/') : '/admin';

        $candidates = [
            $request->session()->get('url.intended'),
            $request->headers->get('referer'),
        ];

        foreach ($candidates as $candidate) {
            if (! is_string($candidate) || $candidate === '') {
                continue;
            }

            $path = parse_url($candidate, PHP_URL_PATH);
            if (! is_string($path)) {
                continue;
            }

            $path = '/'.trim($path, '/');

            if ($path === $adminPath || Str::startsWith($path, $adminPath.'/')) {
                return true;
            }
        }

        return false;
    }

    private function denyAdminAccess(string $title, string $message): RedirectResponse
    {
        return redirect()
            ->route('admin.access-denied')
            ->with('admin_access_denied_title', $title)
            ->with('admin_access_denied_message', $message);
    }

    private function failed(string $message): RedirectResponse
    {
        return redirect()
            ->route('login')
            ->withErrors(['email' => $message]);
    }
}
