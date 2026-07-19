<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HomeHeroImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'alt',
        'link',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getImageUrlAttribute(): ?string
    {
        $path = ltrim((string) $this->image, '/');
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (! str_starts_with($path, 'home-hero/')
            || ! in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)
            || ! Storage::disk('public')->exists($path)) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }

    public function getSafeLinkAttribute(): ?string
    {
        return self::isAllowedLink($this->link) ? trim($this->link) : null;
    }

    public static function isAllowedLink(?string $link): bool
    {
        if (blank($link)) {
            return true;
        }

        $url = filter_var(trim($link), FILTER_VALIDATE_URL);
        if ($url === false) {
            return false;
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));
        $host = strtolower((string) parse_url($url, PHP_URL_HOST));

        return in_array($scheme, ['http', 'https'], true)
            && in_array($host, config('content_security.hero_allowed_link_hosts', []), true);
    }
}
