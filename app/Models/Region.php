<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'region_name',
        'dpc_name',
        'province',
        'description',
        'contact_email',
        'contact_phone',
        'website',
        'address',
        'postal_code',
        'establishment_date',
        'is_active',
        'logo',
        'ketua_dpw',
        'wk_ketua_dpw',
        'sekretaris_dpw',
        'bendahara_dpw',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'establishment_date' => 'date',
    ];

    /**
     * Get the Ketua DPW (Regional Chairman)
     */
    public function ketuaDpw()
    {
        return $this->belongsTo(User::class, 'ketua_dpw');
    }

    /**
     * Get the Wakil Ketua DPW (Regional Vice Chairman)
     */
    public function wkKetuaDpw()
    {
        return $this->belongsTo(User::class, 'wk_ketua_dpw');
    }

    /**
     * Get the Sekretaris DPW (Regional Secretary)
     */
    public function sekretarisDpw()
    {
        return $this->belongsTo(User::class, 'sekretaris_dpw');
    }

    /**
     * Get the Bendahara DPW (Regional Treasurer)
     */
    public function bendaharaDpw()
    {
        return $this->belongsTo(User::class, 'bendahara_dpw');
    }

    /**
     * Calculate DPW completion percentage
     */
    public function getDpwCompletionPercentage(): int
    {
        $positions = ['ketua_dpw', 'wk_ketua_dpw', 'sekretaris_dpw', 'bendahara_dpw'];
        $filled = 0;

        foreach ($positions as $position) {
            if (!is_null($this->$position)) {
                $filled++;
            }
        }

        return (int) round(($filled / count($positions)) * 100);
    }

    /**
     * Check if DPW structure is complete
     */
    public function isDpwComplete(): bool
    {
        return $this->getDpwCompletionPercentage() === 100;
    }
}
