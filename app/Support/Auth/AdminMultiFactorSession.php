<?php

namespace App\Support\Auth;

use Illuminate\Contracts\Auth\Authenticatable;

class AdminMultiFactorSession
{
    public const CONFIRMED_AT_KEY = 'filament.admin.mfa_confirmed_at';

    public const CONFIRMED_USER_KEY = 'filament.admin.mfa_confirmed_user';

    public static function confirm(Authenticatable $user): void
    {
        session([
            self::CONFIRMED_AT_KEY => now()->timestamp,
            self::CONFIRMED_USER_KEY => $user->getAuthIdentifier(),
        ]);
    }

    public static function clear(): void
    {
        session()->forget([
            self::CONFIRMED_AT_KEY,
            self::CONFIRMED_USER_KEY,
        ]);
    }

    public static function isConfirmed(Authenticatable $user): bool
    {
        return filled(session(self::CONFIRMED_AT_KEY))
            && (string) session(self::CONFIRMED_USER_KEY) === (string) $user->getAuthIdentifier();
    }
}
