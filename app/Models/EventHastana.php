<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventHastana extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_category_id',
        'title',
        'slug',
        'description',
        'short_description',
        'image',
        'location',
        'venue',
        'city',
        'province',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'price',
        'is_free',
        'max_participants',
        'current_participants',
        'rating',
        'total_reviews',
        'is_featured',
        'is_trending',
        'is_active',
        'tags',
        'contact_email',
        'contact_phone',
        'organizer_name',
        'requirements',
        'benefits',
        'status',
        'schedule',
        'quota',
        'event_type'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'start_time' => 'time',
        'end_time' => 'time',
        'price' => 'decimal:2',
        'is_free' => 'boolean',
        'max_participants' => 'integer',
        'current_participants' => 'integer',
        'rating' => 'decimal:1',
        'total_reviews' => 'integer',
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
        'is_active' => 'boolean',
        'tags' => 'array',
        'schedule' => 'array',
        'quota' => 'integer'
    ];

    /**
     * Get the event category that owns the event
     */
    public function eventCategory()
    {
        return $this->belongsTo(EventCategory::class);
    }

    /**
     * Get related event registrations
     */
    public function eventRegistrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Scope for published events
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope for active events
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured events
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for trending events
     */
    public function scopeTrending($query)
    {
        return $query->where('is_trending', true);
    }

    /**
     * Scope for free events
     */
    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    /**
     * Scope for upcoming events
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }

    /**
     * Scope for ongoing events
     */
    public function scopeOngoing($query)
    {
        return $query->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    /**
     * Check if registration is still open
     */
    public function isRegistrationOpen(): bool
    {
        return $this->status === 'published' && 
               $this->start_date > now() &&
               ($this->max_participants === null || $this->current_participants < $this->max_participants);
    }

    /**
     * Get remaining slots
     */
    public function getRemainingSlots(): ?int
    {
        if ($this->max_participants === null) {
            return null;
        }
        return max(0, $this->max_participants - $this->current_participants);
    }
}
