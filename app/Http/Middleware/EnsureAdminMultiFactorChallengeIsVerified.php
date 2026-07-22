<?php

namespace App\Http\Middleware;

use App\Support\Auth\AdminMultiFactorSession;
use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminMultiFactorChallengeIsVerified
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $panel = Filament::getCurrentPanel();

        if (! $panel || $panel->getId() !== 'admin' || ! $panel->hasMultiFactorAuthentication()) {
            return $next($request);
        }

        if ($this->shouldSkip($request)) {
            return $next($request);
        }

        $user = Filament::auth()->user();

        if (! $user) {
            return $next($request);
        }

        if (! $this->userHasEnabledMultiFactor($user)) {
            return $next($request);
        }

        if (AdminMultiFactorSession::isConfirmed($user)) {
            return $next($request);
        }

        return redirect()->guest(route('filament.admin.auth.multi-factor-authentication.challenge'));
    }

    private function shouldSkip(Request $request): bool
    {
        return $request->routeIs([
            'filament.admin.auth.multi-factor-authentication.set-up-required',
            'filament.admin.auth.multi-factor-authentication.challenge',
        ]);
    }

    private function userHasEnabledMultiFactor(mixed $user): bool
    {
        foreach (Filament::getMultiFactorAuthenticationProviders() as $provider) {
            if ($provider->isEnabled($user)) {
                return true;
            }
        }

        return false;
    }
}
