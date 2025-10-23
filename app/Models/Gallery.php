<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Gallery extends Model
{
    /** @use HasFactory<\Database\Factories\GalleryFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'image',
        'category',
        'date',
        'location',
        'photographer',
        'wedding_organizer_id',
        'views_count',
        'is_featured',
        'is_published',
        'slug',
        'tags',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'tags' => 'array',
        'views_count' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug from title
        static::creating(function ($gallery) {
            if (empty($gallery->slug)) {
                $gallery->slug = Str::slug($gallery->title);
                
                // Ensure slug is unique
                $count = 1;
                $originalSlug = $gallery->slug;
                while (static::where('slug', $gallery->slug)->exists()) {
                    $gallery->slug = $originalSlug . '-' . $count++;
                }
            }
        });

        // Update slug when title changes
        static::updating(function ($gallery) {
            if ($gallery->isDirty('title') && empty($gallery->slug)) {
                $gallery->slug = Str::slug($gallery->title);
            }
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Scope a query to only include published galleries.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to only include featured galleries.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query to order by most viewed.
     */
    public function scopePopular($query)
    {
        return $query->orderBy('views_count', 'desc');
    }

    /**
     * Scope a query to order by most recent.
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('date', 'desc');
    }

    /**
     * Increment the views count.
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Get the wedding organizer that owns the gallery.
     */
    public function weddingOrganizer()
    {
        return $this->belongsTo(WeddingOrganizer::class);
    }

    /**
     * Get formatted date.
     */
    public function getFormattedDateAttribute()
    {
        return $this->date ? $this->date->format('d M Y') : null;
    }

    /**
     * Get image URL.
     */
    public function getImageUrlAttribute()
    {
        // If empty, return placeholder
        if (empty($this->image)) {
            return 'https://via.placeholder.com/800x800/e5e7eb/6b7280?text=No+Image';
        }
        
        // If already full URL, return as is
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        
        // If starts with 'galleries/', it's uploaded file
        if (Str::startsWith($this->image, 'galleries/')) {
            return asset('storage/' . $this->image);
        }
        
        // Otherwise, assume it's in storage
        return asset('storage/' . $this->image);
    }

    /**
     * Get available categories.
     */
    public static function getCategories()
    {
        return [
            'Resepsi' => 'Resepsi',
            'Akad Nikah' => 'Akad Nikah',
            'Outdoor Wedding' => 'Outdoor Wedding',
            'Dekorasi' => 'Dekorasi',
            'Behind The Scenes' => 'Behind The Scenes',
            'Fashion' => 'Fashion',
            'Planning' => 'Planning',
            'Catering' => 'Catering',
            'Entertainment' => 'Entertainment',
            'Technical' => 'Technical',
            'Preparation' => 'Preparation',
            'Intimate Wedding' => 'Intimate Wedding',
        ];
    }

    /**
     * Get category badge color.
     */
    public function getCategoryColorAttribute()
    {
        return match($this->category) {
            'Resepsi' => 'blue',
            'Akad Nikah' => 'green',
            'Outdoor Wedding' => 'teal',
            'Dekorasi' => 'purple',
            'Behind The Scenes' => 'gray',
            'Fashion' => 'pink',
            'Planning' => 'indigo',
            'Catering' => 'orange',
            'Entertainment' => 'red',
            'Technical' => 'yellow',
            'Preparation' => 'cyan',
            'Intimate Wedding' => 'rose',
            default => 'gray',
        };
    }
}
