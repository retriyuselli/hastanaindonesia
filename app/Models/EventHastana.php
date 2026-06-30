<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'online_link',
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
        'total_reviews' => 'integer',
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
        'is_active' => 'boolean',
        'tags' => 'array',
        'schedule' => 'array',
        'quota' => 'integer',
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
        'category_name',
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
    public function scopePublished(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeActive(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeTrending(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('is_trending', true);
    }

    public function scopeFree(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('is_free', true);
    }

    public function scopeUpcoming(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('start_date', '>', now());
    }

    public function scopeOngoing(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
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
        if (! $capacity) {
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
        if (! $capacity || $capacity <= 0) {
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

        return 'Rp '.number_format($this->price, 0, ',', '.');
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
        if (! $this->start_time) {
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
        if (! $this->image) {
            return 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&h=450&fit=crop&auto=format';
        }

        // If it's already a full URL, return as is
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        // Otherwise, it's a storage path
        return asset('storage/'.$this->image);
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
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
            && ! $this->is_full
            && ! $this->is_past;
    }

    /**
     * Get event type badge
     */
    public function getEventTypeBadgeAttribute(): array
    {
        return match ($this->event_type) {
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
                'available' => false,
            ];
        }

        if (! $this->is_active) {
            return [
                'text' => 'Pendaftaran Ditutup',
                'color' => 'red',
                'icon' => 'ban',
                'available' => false,
            ];
        }

        if ($this->is_full) {
            return [
                'text' => 'SOLD OUT',
                'color' => 'red',
                'icon' => 'times-circle',
                'available' => false,
            ];
        }

        if ($this->capacity_percentage >= 90) {
            return [
                'text' => 'Hampir Penuh',
                'color' => 'orange',
                'icon' => 'exclamation-triangle',
                'available' => true,
            ];
        }

        return [
            'text' => 'Tersedia',
            'color' => 'green',
            'icon' => 'check-circle',
            'available' => true,
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
            $this->province,
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

    public function updateTotalReviews(): void
    {
        $this->total_reviews = $this->approvedReviews()->count();
        $this->save();
    }

    public function addons()
    {
        return $this->hasMany(EventAddon::class);
    }

    public function activeAddons()
    {
        return $this->hasMany(EventAddon::class)->where('is_active', true)->orderBy('sort_order');
    }
}
