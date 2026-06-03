<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'business_license',
        'owner_name',
        'nama_sekretaris_umum',
        'nama_bendahara_umum',
        'nama_bid_organisasi',
        'nama_bid_pengembangan',
        'nama_bid_humas_1',
        'nama_bid_humas_2',
        'nama_bid_sosial',
        'nama_bid_bisnis',
        'nama_bid_hukum',
        'email',
        'phone',
        'address',
        'city',
        'province',
        'postal_code',
        'website',
        'description',
        'logo_url',
        'established_year',
        'employee_count',
        'membership_status',
        'membership_type',
        'joined_date',
        'region_id',

        // Data Legalitas
        'legal_entity_type',
        'deed_of_establishment',
        'deed_date',
        'notary_name',
        'notary_license_number',
        'nib_number',
        'nib_issued_date',
        'nib_valid_until',
        'npwp_number',
        'npwp_issued_date',
        'tax_office',
        'legal_document_status',
        'legal_document_notes',
        'legal_verified_at',
        'legal_verified_by',
        'legal_documents',
    ];

    protected $casts = [
        'joined_date' => 'date',
        'established_year' => 'integer',
        'employee_count' => 'integer',
        'deed_date' => 'date',
        'nib_issued_date' => 'date',
        'nib_valid_until' => 'date',
        'npwp_issued_date' => 'date',
        'legal_verified_at' => 'datetime',
        'legal_documents' => 'array',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function ownerUser()
    {
        return $this->belongsTo(User::class, 'owner_name');
    }

    // ── Relasi Pengurus ke User ──────────────────────────────────
    public function sekretarisUmum()
    {
        return $this->belongsTo(User::class, 'nama_sekretaris_umum');
    }

    public function bendaharaUmum()
    {
        return $this->belongsTo(User::class, 'nama_bendahara_umum');
    }

    public function bidOrganisasi()
    {
        return $this->belongsTo(User::class, 'nama_bid_organisasi');
    }

    public function bidPengembangan()
    {
        return $this->belongsTo(User::class, 'nama_bid_pengembangan');
    }

    public function bidHumas1()
    {
        return $this->belongsTo(User::class, 'nama_bid_humas_1');
    }

    public function bidHumas2()
    {
        return $this->belongsTo(User::class, 'nama_bid_humas_2');
    }

    public function bidSosial()
    {
        return $this->belongsTo(User::class, 'nama_bid_sosial');
    }

    public function bidBisnis()
    {
        return $this->belongsTo(User::class, 'nama_bid_bisnis');
    }

    public function bidHukum()
    {
        return $this->belongsTo(User::class, 'nama_bid_hukum');
    }

    /**
     * Get all event registrations for this company
     */
    public function eventRegistrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Get all portfolios for this company
     */
    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    /**
     * Get user who verified legal documents
     */
    public function legalVerifier()
    {
        return $this->belongsTo(User::class, 'legal_verified_by');
    }

    /**
     * Get legal entity type options
     */
    public static function getLegalEntityTypeOptions(): array
    {
        return [
            'PT' => 'Perseroan Terbatas (PT)',
            'CV' => 'Commanditaire Vennootschap (CV)',
            'Firma' => 'Firma',
            'UD' => 'Usaha Dagang (UD)',
            'Koperasi' => 'Koperasi',
            'Yayasan' => 'Yayasan',
            'Perkumpulan' => 'Perkumpulan',
            'Perorangan' => 'Usaha Perorangan',
        ];
    }

    /**
     * Get region governance information
     */
    public function getRegionGovernanceInfo(): array
    {
        if (! $this->region) {
            return [
                'region_name' => 'No Region',
                'dpw_completion' => 0,
                'ketua_dpw' => null,
                'wk_ketua_dpw' => null,
                'sekretaris_dpw' => null,
                'bendahara_dpw' => null,
            ];
        }

        return [
            'region_name' => $this->region->region_name,
            'province' => $this->region->province,
            'dpw_completion' => $this->region->getDpwCompletionPercentage(),
            'ketua_dpw' => $this->region->ketuaDpw?->user?->name,
            'wk_ketua_dpw' => $this->region->wkKetuaDpw?->user?->name,
            'sekretaris_dpw' => $this->region->sekretarisDpw?->user?->name,
            'bendahara_dpw' => $this->region->bendaharaDpw?->user?->name,
        ];
    }

    /**
     * Check if company's region has complete DPW structure
     */
    public function hasCompleteRegionGovernance(): bool
    {
        return $this->region && $this->region->getDpwCompletionPercentage() === 100;
    }

    /**
     * Get region DPW completion status
     */
    public function getRegionGovernanceStatus(): string
    {
        if (! $this->region) {
            return 'no_region';
        }

        $completion = $this->region->getDpwCompletionPercentage();

        return match (true) {
            $completion === 100 => 'complete',
            $completion >= 75 => 'nearly_complete',
            $completion >= 50 => 'partial',
            $completion > 0 => 'minimal',
            default => 'empty'
        };
    }
}
