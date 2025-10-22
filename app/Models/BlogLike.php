<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'ip_address',
        'user_agent',
        'liked_at'
    ];

    protected $casts = [
        'liked_at' => 'datetime'
    ];

    /**
     * Get the blog that owns the like
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

        static::creating(function ($like) {
            $like->liked_at = now();
        });

        static::created(function ($like) {
            $like->blog->increment('likes_count');
        });

        static::deleted(function ($like) {
            $like->blog->decrement('likes_count');
        });
    }

    /**
     * Check if IP has already liked this blog
     */
    public static function hasLiked($blogId, $ipAddress)
    {
        return static::where('blog_id', $blogId)
                    ->where('ip_address', $ipAddress)
                    ->exists();
    }

    /**
     * Toggle like for a blog
     */
    public static function toggle($blogId, $ipAddress, $userAgent = null)
    {
        $existing = static::where('blog_id', $blogId)
                         ->where('ip_address', $ipAddress)
                         ->first();

        if ($existing) {
            $existing->delete();
            return ['action' => 'unliked', 'count' => Blog::find($blogId)->likes_count];
        } else {
            static::create([
                'blog_id' => $blogId,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent
            ]);
            return ['action' => 'liked', 'count' => Blog::find($blogId)->likes_count];
        }
    }
}
