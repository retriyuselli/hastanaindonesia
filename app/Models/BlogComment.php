<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class BlogComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'name',
        'email',
        'comment',
        'avatar',
        'ip_address',
        'user_agent',
        'is_approved',
        'parent_id'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'created_at' => 'datetime'
    ];

    /**
     * Get the blog that owns the comment
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    /**
     * Get the parent comment (for replies)
     */
    public function parent()
    {
        return $this->belongsTo(BlogComment::class, 'parent_id');
    }

    /**
     * Get the replies to this comment
     */
    public function replies()
    {
        return $this->hasMany(BlogComment::class, 'parent_id')->where('is_approved', true);
    }

    /**
     * Scope for approved comments
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope for top-level comments (not replies)
     */
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope for recent comments
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', Carbon::now()->subDays($days));
    }

    /**
     * Get formatted date
     */
    public function getFormattedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get avatar with fallback
     */
    public function getAvatarUrlAttribute()
    {
        return $this->avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=3B82F6&color=fff';
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($comment) {
            if ($comment->is_approved) {
                $comment->blog->increment('comments_count');
            }
        });

        static::updated(function ($comment) {
            if ($comment->isDirty('is_approved')) {
                if ($comment->is_approved) {
                    $comment->blog->increment('comments_count');
                } else {
                    $comment->blog->decrement('comments_count');
                }
            }
        });

        static::deleted(function ($comment) {
            if ($comment->is_approved) {
                $comment->blog->decrement('comments_count');
            }
        });
    }
}
