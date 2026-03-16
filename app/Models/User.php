<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, HasRoles, Notifiable;

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
     * Get members verified by this user
     */
    // public function verifiedMembers()
    // {
    //     return $this->hasMany(Member::class, 'legal_verified_by');
    // }

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

        return $this->hasAnyRole(['admin', $superAdminRole, $panelUserRole]);
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
