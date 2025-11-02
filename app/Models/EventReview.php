<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_hastana_id',
        'user_id',
        'event_participant_id',
        'rating',
        'title',
        'review',
        'pros',
        'cons',
        'would_recommend',
        'is_verified_participant',
        'is_approved',
        'is_featured',
        'helpful_count',
        'reported_count',
        'moderator_notes',
        'ip_address',
    ];

    protected $casts = [
        'rating' => 'integer',
        'would_recommend' => 'boolean',
        'is_verified_participant' => 'boolean',
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
        'helpful_count' => 'integer',
        'reported_count' => 'integer',
    ];

    /**
     * Get the event that owns the review
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(EventHastana::class, 'event_hastana_id');
    }

    /**
     * Get the user who wrote the review
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event participant (if reviewer is a participant)
     */
    public function participant(): BelongsTo
    {
        return $this->belongsTo(EventParticipant::class, 'event_participant_id');
    }

    /**
     * Scope to get approved reviews only
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope to get featured reviews
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope to get verified participant reviews
     */
    public function scopeVerifiedParticipants($query)
    {
        return $query->where('is_verified_participant', true);
    }

    /**
     * Scope to filter by rating
     */
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Get review rating stars (1-5)
     */
    public function getRatingStarsAttribute()
    {
        return min(5, max(1, $this->rating));
    }

    /**
     * Check if review is helpful
     */
    public function isHelpful(): bool
    {
        return $this->helpful_count > 0;
    }

    /**
     * Mark review as helpful
     */
    public function markAsHelpful(): void
    {
        $this->increment('helpful_count');
    }

    /**
     * Report review
     */
    public function report(): void
    {
        $this->increment('reported_count');
    }

    /**
     * Auto-approve reviews from verified participants
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($review) {
            // Auto-approve reviews from verified participants
            if ($review->is_verified_participant && !isset($review->is_approved)) {
                $review->is_approved = true;
            }

            // Set IP address if not set
            if (!$review->ip_address && request()) {
                $review->ip_address = request()->ip();
            }
        });

        static::created(function ($review) {
            // Update event rating and total reviews
            if ($review->is_approved) {
                $review->event->updateRating();
            }
        });

        static::updated(function ($review) {
            // Update event rating when review is approved/updated
            if ($review->wasChanged('is_approved') || $review->wasChanged('rating')) {
                $review->event->updateRating();
            }
        });

        static::deleted(function ($review) {
            // Update event rating when review is deleted
            $review->event->updateRating();
        });
    }
}
