<?php

namespace App\Filament\Admin\Resources\EventReviews\Pages;

use App\Filament\Admin\Resources\EventReviews\EventReviewResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEventReviews extends ListRecords
{
    protected static string $resource = EventReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
