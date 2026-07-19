<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeHeroImageAudit extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = [
        'home_hero_image_id',
        'user_id',
        'action',
        'before',
        'after',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'before' => 'array',
        'after' => 'array',
        'created_at' => 'datetime',
    ];
}
