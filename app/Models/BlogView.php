<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogView extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'ip_address',
        'user_agent',
        'viewed_at',
        'referrer',
        'duration_seconds',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
        'duration_seconds' => 'integer',
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
            $view->blog->increment('views_count');
        });
    }

    /**
     * Record a view (with uniqueness check)
     */
    public static function record(int $blogId, string $ipAddress, ?string $userAgent = null, ?string $referrer = null)
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
            'referrer' => $referrer,
        ]);
    }

    /**
     * Update duration when user leaves
     */
    public function updateDuration(int $seconds): void
    {
        $this->update(['duration_seconds' => $seconds]);
    }

    /**
     * Get unique views count for a blog
     */
    public static function getUniqueViews(int $blogId, ?int $days = null): int
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
    public static function getAnalytics(int $blogId, int $days = 30): array
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
                ->get(),
        ];
    }
}
