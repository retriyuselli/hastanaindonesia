<?php

namespace App\Models;

use Filament\Auth\MultiFactor\App\Concerns\InteractsWithAppAuthentication;
use Filament\Auth\MultiFactor\App\Concerns\InteractsWithAppAuthenticationRecovery;
use Filament\Auth\MultiFactor\App\Contracts\HasAppAuthentication;
use Filament\Auth\MultiFactor\App\Contracts\HasAppAuthenticationRecovery;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasAppAuthentication, HasAppAuthenticationRecovery
{
    use HasFactory;
    use HasRoles;
    use InteractsWithAppAuthentication;
    use InteractsWithAppAuthenticationRecovery;
    use Notifiable;

    protected static function booted(): void
    {
        static::created(function (self $user) {
            $guardName = config('auth.defaults.guard', 'web');
            $customerRoleExists = Role::query()
                ->where('name', 'customer')
                ->where('guard_name', $guardName)
                ->exists();

            if ($customerRoleExists && $user->roles()->count() === 0) {
                $user->assignRole('customer');
            }
        });
    }

    protected $fillable = [
        'name',
        'email',
        'avatar',
        'phone',
        'address',
        'date_of_birth',
        'gender',
        'status_menikah',
        'password',
        'role',
        'status',
        'email_verified_at',
        'no_anggota',
        'agama',
        'no_ktp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_of_birth' => 'date',
        'role' => 'string',
    ];

    /**
     * Get companies verified by this user
     */
    public function verifiedCompanies()
    {
        return $this->hasMany(Company::class, 'legal_verified_by');
    }

    /**
     * Get wedding organizers verified by this user
     */
    public function verifiedWeddingOrganizers()
    {
        return $this->hasMany(WeddingOrganizer::class, 'verified_by');
    }

    public function weddingOrganizer()
    {
        return $this->hasOne(WeddingOrganizer::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        $superAdminRole = config('filament-shield.super_admin.name', 'super_admin');
        $panelUserRole = config('filament-shield.panel_user.name', 'panel_user');

        if ($this->status !== 'active' || ! $this->hasAnyRole(['admin', $superAdminRole, $panelUserRole])) {
            return false;
        }

        if (app()->isProduction()) {
            if ($this->usesKnownDefaultPassword()) {
                return false;
            }
        }

        return true;
    }

    public function getAuthPassword(): string
    {
        $password = (string) $this->getAttribute($this->getAuthPasswordName());

        if (! app()->isProduction() || ! $this->usesKnownDefaultPassword($password)) {
            return $password;
        }

        static $blockedPasswordHash;

        return $blockedPasswordHash ??= Hash::make(Str::random(64));
    }

    private function usesKnownDefaultPassword(?string $password = null): bool
    {
        $password ??= (string) $this->getAttribute($this->getAuthPasswordName());

        return Cache::remember(
            'security:default-password:'.sha1($password),
            now()->addHour(),
            fn (): bool => Hash::check('password123', $password),
        );
    }

    public function isAdmin(): bool
    {
        $superAdminRole = config('filament-shield.super_admin.name', 'super_admin');

        return $this->hasAnyRole(['admin', $superAdminRole]);
    }

    /**
     * Get avatar URL with storage path
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            // If avatar already has full URL (http/https)
            if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
                return $this->avatar;
            }

            // If avatar is a storage path
            return asset('storage/'.$this->avatar);
        }

        return null;
    }
}
