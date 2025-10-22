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
            // Increment views_count for every single view (no uniqueness check)
            // Every time someone views the blog, count it
            $view->blog->increment('views_count');
        });
    }

    /**
     * Record a view
     */
    public static function record($blogId, $ipAddress, $userAgent = null, $referrer = null)
    {
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
