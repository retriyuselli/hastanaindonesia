<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class EmailAddress
{
    /**
     * Normalize an email for identity comparison.
     *
     * Gmail/Googlemail ignore dots in the local-part and treat +tags as aliases,
     * so ramadhona.utama@gmail.com and ramadhonautama@gmail.com are the same inbox.
     */
    public static function normalize(string $email): string
    {
        $email = Str::lower(trim($email));

        if (! str_contains($email, '@')) {
            return $email;
        }

        [$local, $domain] = explode('@', $email, 2);

        if (! self::isGmailDomain($domain)) {
            return $local.'@'.$domain;
        }

        $plusPosition = strpos($local, '+');
        if ($plusPosition !== false) {
            $local = substr($local, 0, $plusPosition);
        }

        $local = str_replace('.', '', $local);

        return $local.'@gmail.com';
    }

    public static function isGmailDomain(string $domain): bool
    {
        $domain = Str::lower(trim($domain));

        return in_array($domain, ['gmail.com', 'googlemail.com'], true);
    }

    /**
     * Find a user by email, treating Gmail dot/+ aliases as the same identity.
     * If multiple local accounts match the same Gmail inbox, the oldest account wins.
     */
    public static function findUser(string $email): ?User
    {
        $candidates = self::candidates($email);

        if ($candidates->isEmpty()) {
            return null;
        }

        $needle = Str::lower(trim($email));
        $exact = $candidates->first(
            fn (User $user): bool => Str::lower($user->email) === $needle,
        );

        if ($exact && $candidates->count() === 1) {
            return $exact;
        }

        return $candidates->sortBy('id')->first();
    }

    public static function exists(string $email, ?int $ignoreUserId = null): bool
    {
        $user = self::candidates($email)
            ->when(
                $ignoreUserId !== null,
                fn (Collection $users) => $users->reject(
                    fn (User $user): bool => (int) $user->id === $ignoreUserId,
                ),
            )
            ->isNotEmpty();

        return $user;
    }

    /**
     * @return Collection<int, User>
     */
    private static function candidates(string $email): Collection
    {
        $email = Str::lower(trim($email));
        $normalized = self::normalize($email);

        $query = User::query()->whereRaw('LOWER(email) = ?', [$email]);

        if (str_ends_with($normalized, '@gmail.com')) {
            $query->orWhere(function ($builder): void {
                $builder->whereRaw('LOWER(email) LIKE ?', ['%@gmail.com'])
                    ->orWhereRaw('LOWER(email) LIKE ?', ['%@googlemail.com']);
            });
        }

        return $query
            ->get()
            ->filter(function (User $user) use ($email, $normalized): bool {
                $userEmail = Str::lower($user->email);

                return $userEmail === $email || self::normalize($userEmail) === $normalized;
            })
            ->values();
    }
}
