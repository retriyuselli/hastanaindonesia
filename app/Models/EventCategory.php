<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'icon',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Get events in this category
     */
    public function events()
    {
        return $this->hasMany(EventHastana::class, 'event_category_id');
    }

    /**
     * Get event hastanas in this category
     */
    public function eventHastanas()
    {
        return $this->hasMany(EventHastana::class, 'event_category_id');
    }

    /**
     * Scope for active categories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
