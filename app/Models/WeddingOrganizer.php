<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingOrganizer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'region_id',
        'organizer_name',
        'brand_name',
        'description',
        'phone',
        'email',
        'website',
        'instagram',
        'address',
        'city',
        'province',
        'postal_code',
        'certification_level',
        'established_year',
        'business_type',
        'business_license',
        'specializations',
        'services',
        'price_range_min',
        'price_range_max',
        'completed_events',
        'rating',
        'awards',
        'verification_status',
        'is_featured',
        'is_approved',
        'is_active',
        'subscribe_newsletter',
        'slug',
        'status',
        'verified_at',
        'verified_by',
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
        'legal_documents'
    ];

    protected $casts = [
        'specializations' => 'array',
        'services' => 'array',
        'legal_documents' => 'array',
        'price_range_min' => 'decimal:2',
        'price_range_max' => 'decimal:2',
        'established_year' => 'integer',
        'completed_events' => 'integer',
        'rating' => 'decimal:1',
        'is_featured' => 'boolean',
        'is_approved' => 'boolean',
        'is_active' => 'boolean',
        'subscribe_newsletter' => 'boolean',
        'verified_at' => 'datetime',
        'deed_date' => 'date',
        'nib_issued_date' => 'date',
        'nib_valid_until' => 'date',
        'npwp_issued_date' => 'date',
        'legal_verified_at' => 'datetime'
    ];

    /**
     * Get the user that owns the wedding organizer
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the region where wedding organizer is located
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get user who verified the wedding organizer
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Get user who verified the legal documents
     */
    public function legalVerifier()
    {
        return $this->belongsTo(User::class, 'legal_verified_by');
    }

    /**
     * Get all products for this wedding organizer
     */
    public function products()
    {
        return $this->hasMany(Product::class)->orderBy('sort_order');
    }

    /**
     * Get active products
     */
    public function activeProducts()
    {
        return $this->hasMany(Product::class)->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Scope for verified wedding organizers
     */
    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'verified');
    }

    /**
     * Scope for active wedding organizers
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for featured wedding organizers
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for legal document verified organizers
     */
    public function scopeLegalVerified($query)
    {
        return $query->where('legal_document_status', 'verified');
    }

    /**
     * Get price range formatted
     */
    public function getPriceRangeFormattedAttribute()
    {
        if ($this->price_range_min && $this->price_range_max) {
            return 'Rp ' . number_format($this->price_range_min) . ' - Rp ' . number_format($this->price_range_max);
        }
        return 'Harga belum ditentukan';
    }

    /**
     * Get business age in years
     */
    public function getBusinessAgeAttribute()
    {
        if ($this->established_year) {
            return now()->year - $this->established_year;
        }
        return null;
    }

    /**
     * Check if legal documents are complete
     */
    public function hasCompleteLegalDocuments()
    {
        return $this->legal_document_status === 'verified' && 
               !empty($this->nib_number) && 
               !empty($this->npwp_number);
    }
}
