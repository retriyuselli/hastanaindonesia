<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class BlogView extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'ip_address',
        'user_agent',
        'viewed_at',
        'referrer',
        'duration_seconds'
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
        'duration_seconds' => 'integer'
    ];

    /**
     * Get the blog that owns the view
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($view) {
            $view->viewed_at = now();
        });

        static::created(function ($view) {
            // Only increment if this is a unique view
            // Check if this IP has viewed in the last 24 hours
            $existingView = static::where('blog_id', $view->blog_id)
                ->where('ip_address', $view->ip_address)
                ->where('viewed_at', '>=', now()->subHours(24))
                ->where('id', '!=', $view->id)
                ->exists();

            // Only increment if no recent view from same IP
            if (!$existingView) {
                $view->blog->increment('views_count');
            }
        });
    }

    /**
     * Record a view (with uniqueness check)
     */
    public static function record($blogId, $ipAddress, $userAgent = null, $referrer = null)
    {
        // Check if this IP already viewed in last 24 hours
        $recentView = static::where('blog_id', $blogId)
            ->where('ip_address', $ipAddress)
            ->where('viewed_at', '>=', now()->subHours(24))
            ->first();

        // If already viewed recently, just update the timestamp
        if ($recentView) {
            $recentView->update(['viewed_at' => now()]);
            return $recentView;
        }

        // Create new view record
        return static::create([
            'blog_id' => $blogId,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'referrer' => $referrer
        ]);
    }

    /**
     * Update duration when user leaves
     */
    public function updateDuration($seconds)
    {
        $this->update(['duration_seconds' => $seconds]);
    }

    /**
     * Get unique views count for a blog
     */
    public static function getUniqueViews($blogId, $days = null)
    {
        $query = static::where('blog_id', $blogId)
                      ->distinct('ip_address');

        if ($days) {
            $query->where('viewed_at', '>=', Carbon::now()->subDays($days));
        }

        return $query->count();
    }

    /**
     * Get views analytics for a blog
     */
    public static function getAnalytics($blogId, $days = 30)
    {
        $query = static::where('blog_id', $blogId)
                      ->where('viewed_at', '>=', Carbon::now()->subDays($days));

        return [
            'total_views' => $query->count(),
            'unique_views' => $query->distinct('ip_address')->count(),
            'avg_duration' => $query->whereNotNull('duration_seconds')->avg('duration_seconds'),
            'top_referrers' => $query->whereNotNull('referrer')
                                   ->selectRaw('referrer, COUNT(*) as count')
                                   ->groupBy('referrer')
                                   ->orderByDesc('count')
                                   ->limit(5)
                                   ->get()
        ];
    }
}
