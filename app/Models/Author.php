<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'email',
        'bio',
        'avatar',
        'website',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all blogs by this author
     */
    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }

    /**
     * Get published blogs by this author
     */
    public function publishedBlogs(): HasMany
    {
        return $this->hasMany(Blog::class)
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->orderByDesc('published_at');
    }

    /**
     * Get avatar URL accessor
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            // Check if it's already a full URL
            if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
                return $this->avatar;
            }
            
            // Otherwise, it's a storage path
            return asset('storage/' . $this->avatar);
        }

        // Default avatar placeholder
        return asset('/images/default-avatar.jpg');
    }

    /**
     * Get total published blogs count
     */
    public function getPublishedBlogsCountAttribute(): int
    {
        return $this->publishedBlogs()->count();
    }

    /**
     * Get total views across all blogs
     */
    public function getTotalViewsAttribute(): int
    {
        return $this->blogs()->sum('views_count');
    }

    /**
     * Get total likes across all blogs
     */
    public function getTotalLikesAttribute(): int
    {
        return $this->blogs()->withCount('likes')->get()->sum('likes_count');
    }
}
