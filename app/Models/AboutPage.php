<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AboutPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'history',
        'vision',
        'mission',
        'values',
        'programs',
        'is_active'
    ];

    protected $casts = [
        'values' => 'array',
        'programs' => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * Get the active about page (singleton pattern)
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first() ?? static::first();
    }
}
