<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'event_name',
        'event_type',
        'description',
        'start_date',
        'end_date',
        'location',
        'is_paid',
        'fee_amount',
        'quota',
        'status',
        'is_certificate_provided',
        'certificate_title',
        'certificate_file',
        'certificate_issuer',
        'certificate_notes',
        'certificate_number_format',
        'certificate_issue_date',
        'certificate_signature',
        'certificate_sign_position',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'certificate_issue_date' => 'date',
        'is_paid' => 'boolean',
        'is_certificate_provided' => 'boolean',
        'fee_amount' => 'integer',
        'quota' => 'integer'
    ];

    /**
     * Get the company that owns the event registration
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get event hastana if related
     */
    public function eventHastana()
    {
        return $this->belongsTo(EventHastana::class);
    }

    /**
     * Scope for published events
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope for paid events
     */
    public function scopePaid($query)
    {
        return $query->where('is_paid', true);
    }

    /**
     * Scope for free events
     */
    public function scopeFree($query)
    {
        return $query->where('is_paid', false);
    }

    /**
     * Scope for events with certificates
     */
    public function scopeWithCertificate($query)
    {
        return $query->where('is_certificate_provided', true);
    }

    /**
     * Get fee amount formatted
     */
    public function getFeeAmountFormattedAttribute()
    {
        if ($this->is_paid && $this->fee_amount) {
            return 'Rp ' . number_format($this->fee_amount);
        }
        return 'Gratis';
    }

    /**
     * Check if event is ongoing
     */
    public function isOngoing(): bool
    {
        $now = now()->toDateString();
        return $this->start_date <= $now && ($this->end_date >= $now || is_null($this->end_date));
    }

    /**
     * Check if event has ended
     */
    public function hasEnded(): bool
    {
        if (is_null($this->end_date)) {
            return $this->start_date < now()->toDateString();
        }
        return $this->end_date < now()->toDateString();
    }
}
