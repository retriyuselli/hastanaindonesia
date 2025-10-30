<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes;

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
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            
            // Auto calculate discount
            if ($product->original_price && $product->price) {
                $product->discount = $product->original_price - $product->price;
            }
        });

        static::updating(function ($product) {
            // Auto update slug if name changed
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            
            // Auto recalculate discount
            if ($product->isDirty(['original_price', 'price'])) {
                $product->discount = $product->original_price - $product->price;
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
        if (!is_array($this->images) || count($this->images) === 0) {
            return 'https://images.unsplash.com/photo-1519741497674-611481863552?w=500&h=500&fit=crop';
        }

        $firstImage = $this->images[0];
        
        // If already a full URL, return as is
        if (str_starts_with($firstImage, 'http://') || str_starts_with($firstImage, 'https://')) {
            return $firstImage;
        }
        
        // Check if file exists in storage
        $storagePath = storage_path('app/public/' . $firstImage);
        if (file_exists($storagePath)) {
            return Storage::url($firstImage);
        }
        
        // Return placeholder if file doesn't exist
        return 'https://images.unsplash.com/photo-1519741497674-611481863552?w=500&h=500&fit=crop';
    }

    /**
     * Get discount percentage
     */
    public function getDiscountPercentageAttribute()
    {
        if ($this->original_price > 0) {
            return round(($this->discount / $this->original_price) * 100);
        }
        return 0;
    }
}
