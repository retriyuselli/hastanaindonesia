<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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
        'event_type',
        'location_type',
        'online_link'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
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

    protected $appends = [
        'current_participants',
        'capacity',
        'remaining_quota',
        'is_full',
        'is_past',
        'is_upcoming',
        'is_ongoing',
        'capacity_percentage',
        'formatted_price',
        'formatted_date',
        'formatted_time',
        'image_url',
        'status_badge',
        'category_name'
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

    /**
     * Get current participants count from actual registrations
     * Count only confirmed and attended participants
     */
    public function getCurrentParticipantsAttribute(): int
    {
        // If accessing from collection (already loaded), use database field
        if (array_key_exists('current_participants', $this->attributes)) {
            return (int) $this->attributes['current_participants'];
        }
        
        // Otherwise, count from relationship (confirmed + attended)
        return $this->participants()
            ->whereIn('status', ['confirmed', 'attended'])
            ->count();
    }

    /**
     * Get capacity (alias for max_participants)
     */
    public function getCapacityAttribute(): ?int
    {
        return $this->max_participants ?? $this->quota;
    }

    /**
     * Get remaining quota
     */
    public function getRemainingQuotaAttribute(): int
    {
        $capacity = $this->capacity;
        if (!$capacity) {
            return 0;
        }
        return max(0, $capacity - $this->current_participants);
    }

    /**
     * Check if event is full
     */
    public function getIsFullAttribute(): bool
    {
        return $this->remaining_quota <= 0;
    }

    /**
     * Check if event is past
     */
    public function getIsPastAttribute(): bool
    {
        return $this->start_date < now();
    }

    /**
     * Check if event is upcoming
     */
    public function getIsUpcomingAttribute(): bool
    {
        return $this->start_date > now();
    }

    /**
     * Check if event is ongoing
     */
    public function getIsOngoingAttribute(): bool
    {
        return $this->start_date <= now() && $this->end_date >= now();
    }

    /**
     * Get capacity percentage
     */
    public function getCapacityPercentageAttribute(): float
    {
        $capacity = $this->capacity;
        if (!$capacity || $capacity <= 0) {
            return 0;
        }
        return ($this->current_participants / $capacity) * 100;
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        if ($this->is_free) {
            return 'GRATIS';
        }
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get formatted date
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->start_date->isoFormat('dddd, D MMMM YYYY');
    }

    /**
     * Get formatted time
     */
    public function getFormattedTimeAttribute(): string
    {
        if (!$this->start_time) {
            return '-';
        }
        $start = Carbon::parse($this->start_time)->format('H:i');
        $end = $this->end_time ? Carbon::parse($this->end_time)->format('H:i') : '';
        return $end ? "$start - $end WIB" : "$start WIB";
    }

    /**
     * Get image URL
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }
        return Storage::url($this->image);
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute(): array
    {
        return match($this->status) {
            'published' => ['text' => 'Published', 'color' => 'green'],
            'draft' => ['text' => 'Draft', 'color' => 'gray'],
            'archived' => ['text' => 'Archived', 'color' => 'red'],
            default => ['text' => ucfirst($this->status), 'color' => 'blue']
        };
    }

    /**
     * Get category name
     */
    public function getCategoryNameAttribute(): ?string
    {
        return $this->eventCategory?->name;
    }

    /**
     * Check if user can register
     */
    public function canRegister(): bool
    {
        return $this->status === 'published' 
            && $this->is_active 
            && !$this->is_full 
            && !$this->is_past;
    }

    /**
     * Get event type badge
     */
    public function getEventTypeBadgeAttribute(): array
    {
        return match($this->event_type) {
            'online' => ['text' => 'Online', 'color' => 'blue', 'icon' => 'globe'],
            'offline' => ['text' => 'Offline', 'color' => 'green', 'icon' => 'map-marker-alt'],
            'hybrid' => ['text' => 'Hybrid', 'color' => 'purple', 'icon' => 'random'],
            default => ['text' => 'Event', 'color' => 'gray', 'icon' => 'calendar']
        };
    }

    /**
     * Get availability status
     */
    public function getAvailabilityStatusAttribute(): array
    {
        if ($this->is_past) {
            return [
                'text' => 'Event Sudah Berakhir',
                'color' => 'gray',
                'icon' => 'clock',
                'available' => false
            ];
        }

        if (!$this->is_active) {
            return [
                'text' => 'Pendaftaran Ditutup',
                'color' => 'red',
                'icon' => 'ban',
                'available' => false
            ];
        }

        if ($this->is_full) {
            return [
                'text' => 'SOLD OUT',
                'color' => 'red',
                'icon' => 'times-circle',
                'available' => false
            ];
        }

        if ($this->capacity_percentage >= 90) {
            return [
                'text' => 'Hampir Penuh',
                'color' => 'orange',
                'icon' => 'exclamation-triangle',
                'available' => true
            ];
        }

        return [
            'text' => 'Tersedia',
            'color' => 'green',
            'icon' => 'check-circle',
            'available' => true
        ];
    }

    /**
     * Get short location (city only)
     */
    public function getShortLocationAttribute(): string
    {
        return $this->city ?? $this->location ?? 'Location TBA';
    }

    /**
     * Get full location
     */
    public function getFullLocationAttribute(): string
    {
        $parts = array_filter([
            $this->venue,
            $this->city,
            $this->province
        ]);
        
        return implode(', ', $parts) ?: 'Location TBA';
    }

    /**
     * Get participants for this event
     */
    public function participants()
    {
        return $this->hasMany(EventParticipant::class);
    }

    /**
     * Get reviews for this event
     */
    public function reviews()
    {
        return $this->hasMany(EventReview::class);
    }

    /**
     * Get approved reviews only
     */
    public function approvedReviews()
    {
        return $this->hasMany(EventReview::class)->where('is_approved', true);
    }

    /**
     * Update event rating and total reviews based on approved reviews
     */
    public function updateRating(): void
    {
        $approvedReviews = $this->approvedReviews()->get();
        
        $this->total_reviews = $approvedReviews->count();
        
        if ($this->total_reviews > 0) {
            $this->rating = round($approvedReviews->avg('rating'), 2);
        } else {
            $this->rating = 0;
        }
        
        $this->save();
    }

    /**
     * Get average rating with total reviews
     */
    public function getAverageRatingAttribute(): array
    {
        return [
            'average' => $this->rating ?? 0,
            'total' => $this->total_reviews ?? 0,
            'formatted' => number_format($this->rating ?? 0, 1),
        ];
    }

    /**
     * Get rating distribution (1-5 stars)
     */
    public function getRatingDistribution(): array
    {
        $distribution = [];
        
        for ($i = 5; $i >= 1; $i--) {
            $count = $this->approvedReviews()->where('rating', $i)->count();
            $percentage = $this->total_reviews > 0 ? ($count / $this->total_reviews) * 100 : 0;
            
            $distribution[$i] = [
                'count' => $count,
                'percentage' => round($percentage, 1),
            ];
        }
        
        return $distribution;
    }
}
