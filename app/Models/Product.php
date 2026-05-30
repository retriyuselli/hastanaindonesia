<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_PUBLISHED = 'published';
    const STATUS_DRAFT     = 'draft';
    const STATUS_ARCHIVED  = 'archived';

    const VISIBILITY_PUBLIC       = 'public';
    const VISIBILITY_MEMBERS_ONLY = 'members_only';
    const VISIBILITY_PRIVATE      = 'private';

    protected $fillable = [
        'wedding_organizer_id',
        'name',
        'slug',
        'description',
        'original_price',
        'price',
        'discount',
        'images',
        'features',
        'badges',
        'limited_offer',
        'is_active',
        'status',
        'visibility',
        'sort_order',
    ];

    protected $casts = [
        'original_price' => 'decimal:2',
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'images' => 'array',
        'features' => 'array',
        'badges' => 'array',
        'limited_offer' => 'boolean',
        'is_active' => 'boolean',
        'status' => 'string',
        'visibility' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }

            if ($product->original_price && $product->price) {
                $product->discount = max(0, $product->original_price - $product->price);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }

            if ($product->isDirty(['original_price', 'price'])) {
                $product->discount = max(0, $product->original_price - $product->price);
            }
        });
    }

    /**
     * Get the wedding organizer that owns the product
     */
    public function weddingOrganizer()
    {
        return $this->belongsTo(WeddingOrganizer::class);
    }

    /**
     * Scope for active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for published products
     */
    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    /**
     * Scope for publicly visible products
     */
    public function scopePubliclyVisible($query)
    {
        return $query->where('visibility', self::VISIBILITY_PUBLIC);
    }

    /**
     * Scope untuk tampil di homepage: aktif, published, dan public
     */
    public function scopeVisibleOnHomepage($query)
    {
        return $query->where('is_active', true)
            ->where('status', self::STATUS_PUBLISHED)
            ->where('visibility', self::VISIBILITY_PUBLIC);
    }

    /**
     * Scope for limited offers
     */
    public function scopeLimitedOffer($query)
    {
        return $query->where('limited_offer', true);
    }

    /**
     * Get the main image
     */
    public function getMainImageAttribute()
    {
        if (! is_array($this->images) || count($this->images) === 0) {
            return 'https://images.unsplash.com/photo-1519741497674-611481863552?w=500&h=500&fit=crop';
        }

        $firstImage = $this->images[0];

        // If already a full URL, return as is
        if (str_starts_with($firstImage, 'http://') || str_starts_with($firstImage, 'https://')) {
            return $firstImage;
        }

        // Check if file exists in storage
        $storagePath = storage_path('app/public/'.$firstImage);
        if (file_exists($storagePath)) {
            return Storage::url($firstImage);
        }

        // Return placeholder if file doesn't exist
        return 'https://images.unsplash.com/photo-1519741497674-611481863552?w=500&h=500&fit=crop';
    }

    /**
     * Get discount percentage calculated live from original_price and price
     */
    public function getDiscountPercentageAttribute(): int
    {
        $original = (float) $this->original_price;
        $current  = (float) $this->price;

        if ($original <= 0 || $current >= $original) {
            return 0;
        }

        return (int) round((($original - $current) / $original) * 100);
    }

    /**
     * Check whether price is lower than original (has real discount)
     */
    public function getHasDiscountAttribute(): bool
    {
        return (float) $this->price < (float) $this->original_price;
    }
}
