<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Notifiable;

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
        'no_ktp'
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
    public function verifiedMembers()
    {
        return $this->hasMany(Member::class, 'legal_verified_by');
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

    /**
     * Check if user has a specific role
     */
    public function hasRole($role)
    {
        if (is_array($role)) {
            return in_array($this->role, $role);
        }
        return $this->role === $role;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return in_array($this->role, ['admin', 'super_admin']);
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
            return asset('storage/' . $this->avatar);
        }
        return null;
    }
}
