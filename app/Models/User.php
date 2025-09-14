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
        'date_of_birth',
        'gender',
        'password',
        'role',
        'email_verified_at'
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
     * Get member profile for this user
     */
    public function member()
    {
        return $this->hasOne(Member::class);
    }

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
}
