<?php

namespace App\Observers;

use App\Models\HomeHeroImage;
use App\Models\HomeHeroImageAudit;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class HomeHeroImageObserver
{
    private const AUDITED_FIELDS = [
        'image',
        'alt',
        'link',
        'is_active',
        'sort_order',
    ];

    public function created(HomeHeroImage $homeHeroImage): void
    {
        $this->record($homeHeroImage, 'created', null, $this->snapshot($homeHeroImage));
    }

    public function updated(HomeHeroImage $homeHeroImage): void
    {
        $before = collect(self::AUDITED_FIELDS)
            ->mapWithKeys(fn (string $field) => [$field => $homeHeroImage->getRawOriginal($field)])
            ->all();

        $this->record($homeHeroImage, 'updated', $before, $this->snapshot($homeHeroImage));
    }

    public function deleted(HomeHeroImage $homeHeroImage): void
    {
        $this->record($homeHeroImage, 'deleted', $this->snapshot($homeHeroImage), null);
    }

    private function record(
        HomeHeroImage $homeHeroImage,
        string $action,
        ?array $before,
        ?array $after,
    ): void {
        Cache::forget('home:hero_images');

        HomeHeroImageAudit::create([
            'home_hero_image_id' => $homeHeroImage->getKey(),
            'user_id' => auth()->id(),
            'action' => $action,
            'before' => $before,
            'after' => $after,
            'ip_address' => request()->ip(),
            'user_agent' => Str::limit((string) request()->userAgent(), 1000, ''),
        ]);
    }

    private function snapshot(HomeHeroImage $homeHeroImage): array
    {
        return collect(self::AUDITED_FIELDS)
            ->mapWithKeys(fn (string $field) => [$field => $homeHeroImage->getAttribute($field)])
            ->all();
    }
}
