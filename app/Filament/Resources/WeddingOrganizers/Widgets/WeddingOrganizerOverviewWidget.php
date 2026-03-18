<?php

namespace App\Filament\Resources\WeddingOrganizers\Widgets;

use App\Models\WeddingOrganizer;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WeddingOrganizerOverviewWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $total = WeddingOrganizer::query()->count();
        $verified = WeddingOrganizer::query()->where('verification_status', 'verified')->count();
        $active = WeddingOrganizer::query()->where('status', 'active')->count();
        $featured = WeddingOrganizer::query()->where('is_featured', true)->count();
        $legalVerified = WeddingOrganizer::query()->where('legal_document_status', 'verified')->count();
        $avgRating = WeddingOrganizer::query()->whereNotNull('rating')->avg('rating');

        return [
            Stat::make('Total WO', number_format($total))
                ->description("{$active} aktif, {$verified} terverifikasi")
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success')
                ->chart([0, (int) ($total * 0.25), (int) ($total * 0.5), (int) ($total * 0.75), $total]),

            Stat::make('Featured', number_format($featured))
                ->description('WO unggulan')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning')
                ->chart([0, (int) ($featured * 0.4), (int) ($featured * 0.7), $featured]),

            Stat::make('Dokumen Legal', number_format($legalVerified))
                ->description('Terverifikasi')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('info')
                ->chart([0, (int) ($legalVerified * 0.4), (int) ($legalVerified * 0.7), $legalVerified]),

            Stat::make('Rating Rata-rata', $avgRating ? number_format((float) $avgRating, 1).' / 5.0' : 'Belum ada')
                ->description('Dari WO yang memiliki rating')
                ->descriptionIcon('heroicon-m-star')
                ->color('success')
                ->chart([3.0, 3.5, 4.0, 4.3, (float) ($avgRating ?? 0)]),
        ];
    }
}

