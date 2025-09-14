<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'wedding_organizer_id',
        'title',
        'description',
        'images',
        'video_url',
        'featured'
    ];

    protected $casts = [
        'images' => 'array',
        'featured' => 'boolean'
    ];

    /**
     * Get the wedding organizer that owns the portfolio
     */
    public function weddingOrganizer()
    {
        return $this->belongsTo(WeddingOrganizer::class);
    }

    /**
     * Scope for featured portfolios
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Get the first image from images array
     */
    public function getFirstImageAttribute()
    {
        if ($this->images && is_array($this->images) && count($this->images) > 0) {
            return $this->images[0];
        }
        return null;
    }

    /**
     * Get total number of images
     */
    public function getImageCountAttribute()
    {
        if ($this->images && is_array($this->images)) {
            return count($this->images);
        }
        return 0;
    }

    /**
     * Check if portfolio has video
     */
    public function hasVideo()
    {
        return !empty($this->video_url);
    }
}
