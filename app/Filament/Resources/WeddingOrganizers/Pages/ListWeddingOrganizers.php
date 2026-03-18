<?php

namespace App\Filament\Resources\WeddingOrganizers\Pages;

use App\Filament\Resources\WeddingOrganizers\WeddingOrganizerResource;
use App\Filament\Resources\WeddingOrganizers\Widgets\WeddingOrganizerOverviewWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWeddingOrganizers extends ListRecords
{
    protected static string $resource = WeddingOrganizerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            WeddingOrganizerOverviewWidget::class,
        ];
    }
}
