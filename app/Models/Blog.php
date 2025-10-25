<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'summary',
        'featured_image',
        'blog_category_id',
        'author_id',
        'author_name',  // Deprecated - will be removed
        'author_avatar',  // Deprecated - will be removed
        'meta_title',
        'meta_description',
        'seo_keywords',
        'tags',
        'read_time',
        'views_count',
        'likes_count',
        'comments_count',
        'engagement_score',
        'is_published',
        'is_featured',
        'status',
        'published_at'
    ];

    protected $casts = [
        'tags' => 'array',
        'seo_keywords' => 'array',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'read_time' => 'integer',
        'views_count' => 'integer',
        'likes_count' => 'integer',
        'comments_count' => 'integer',
        'engagement_score' => 'decimal:2'
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
            
            if ($blog->is_published && !$blog->published_at) {
                $blog->published_at = now();
            }
            
            // Auto-calculate read time if not set
            if (empty($blog->read_time) && !empty($blog->content)) {
                $blog->read_time = $blog->calculateReadTime();
            }
        });

        static::updating(function ($blog) {
            if ($blog->isDirty('title') && empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
            
            if ($blog->isDirty('is_published') && $blog->is_published && !$blog->published_at) {
                $blog->published_at = now();
            }
            
            // Auto-recalculate read time if content changed
            if ($blog->isDirty('content') && !empty($blog->content)) {
                $blog->read_time = $blog->calculateReadTime();
            }
        });
    }

    /**
     * Get the blog category
     */
    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class);
    }
    
    /**
     * Get the blog category (alias for easier access)
     */
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    /**
     * Get the blog author
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Get the blog comments
     */
    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }

    /**
     * Get approved comments
     */
    public function approvedComments()
    {
        return $this->hasMany(BlogComment::class)->where('is_approved', true);
    }

    /**
     * Get top-level approved comments
     */
    public function topLevelComments()
    {
        return $this->hasMany(BlogComment::class)
                    ->where('is_approved', true)
                    ->whereNull('parent_id')
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Get the blog likes
     */
    public function likes()
    {
        return $this->hasMany(BlogLike::class);
    }

    /**
     * Get the blog views
     */
    public function views()
    {
        return $this->hasMany(BlogView::class);
    }

    /**
     * Scope for published blogs
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope for featured blogs
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for recent blogs
     */
    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('published_at', 'desc')->limit($limit);
    }

    /**
     * Scope for popular blogs (by views)
     */
    public function scopePopular($query, $limit = 10)
    {
        return $query->orderBy('views_count', 'desc')->limit($limit);
    }

    /**
     * Get formatted published date
     */
    public function getFormattedDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('d M Y') : $this->created_at->format('d M Y');
    }

    /**
     * Get featured image URL
     */
    public function getFeaturedImageUrlAttribute()
    {
        if (!$this->featured_image) {
            return 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&h=450&fit=crop&auto=format';
        }
        
        // If it's already a full URL, return as is
        if (Str::startsWith($this->featured_image, ['http://', 'https://'])) {
            return $this->featured_image;
        }
        
        // Otherwise, it's a storage path
        return asset('storage/' . $this->featured_image);
    }

    /**
     * Get reading time in human readable format
     */
    public function getReadingTimeAttribute()
    {
        return $this->read_time . ' min read';
    }

    /**
     * Calculate reading time based on content
     * Average reading speed: 200-250 words per minute
     * We use 225 as middle ground
     */
    public function calculateReadTime()
    {
        if (empty($this->content)) {
            return 1; // Minimum 1 minute
        }
        
        // Strip HTML tags and count words
        $text = strip_tags($this->content);
        $wordCount = str_word_count($text);
        
        // Calculate minutes (225 words per minute)
        $minutes = ceil($wordCount / 225);
        
        // Minimum 1 minute, even for short articles
        return max(1, $minutes);
    }

    /**
     * Get word count of content
     */
    public function getWordCountAttribute()
    {
        return str_word_count(strip_tags($this->content));
    }

    /**
     * Get excerpt with fallback
     */
    public function getExcerptOrContentAttribute()
    {
        return $this->excerpt ?: Str::limit(strip_tags($this->content), 150);
    }

    /**
     * Increment views count
     */
    public function incrementViews($ipAddress = null, $userAgent = null, $referrer = null)
    {
        // Record the view
        BlogView::record($this->id, $ipAddress, $userAgent, $referrer);
        
        // Update engagement score
        $this->updateEngagementScore();
    }

    /**
     * Check if IP has liked this blog
     */
    public function isLikedBy($ipAddress)
    {
        return BlogLike::hasLiked($this->id, $ipAddress);
    }

    /**
     * Toggle like for this blog
     */
    public function toggleLike($ipAddress, $userAgent = null)
    {
        $result = BlogLike::toggle($this->id, $ipAddress, $userAgent);
        $this->updateEngagementScore();
        return $result;
    }

    /**
     * Calculate and update engagement score
     */
    public function updateEngagementScore()
    {
        $score = 0;
        
        // Views contribute 1 point each
        $score += $this->views_count * 1;
        
        // Likes contribute 3 points each
        $score += $this->likes_count * 3;
        
        // Comments contribute 5 points each
        $score += $this->comments_count * 5;
        
        // Normalize by days since published (to favor recent content)
        $daysSincePublished = $this->published_at ? $this->published_at->diffInDays(now()) + 1 : 1;
        $normalizedScore = $score / $daysSincePublished;
        
        $this->update(['engagement_score' => round($normalizedScore, 2)]);
    }

    /**
     * Get engagement statistics
     */
    public function getEngagementStats()
    {
        return [
            'views' => $this->views_count,
            'likes' => $this->likes_count,
            'comments' => $this->comments_count,
            'engagement_rate' => $this->views_count > 0 ? 
                round((($this->likes_count + $this->comments_count) / $this->views_count) * 100, 2) : 0,
            'score' => $this->engagement_score
        ];
    }

    /**
     * Scope for trending blogs (high engagement)
     */
    public function scopeTrending($query, $days = 7)
    {
        return $query->where('published_at', '>=', Carbon::now()->subDays($days))
                    ->orderBy('engagement_score', 'desc');
    }

    /**
     * Get the route key for the model
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get blog URL
     */
    public function getUrlAttribute()
    {
        return route('blog.detail', $this->slug);
    }

    /**
     * Get meta title with fallback
     */
    public function getMetaTitleAttribute($value)
    {
        return $value ?: $this->title;
    }

    /**
     * Get meta description with fallback
     */
    public function getMetaDescriptionAttribute($value)
    {
        return $value ?: $this->excerpt_or_content;
    }
}
