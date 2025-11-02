<?php

namespace App\Filament\Admin\Resources\EventReviews\Pages;

use App\Filament\Admin\Resources\EventReviews\EventReviewResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEventReview extends CreateRecord
{
    protected static string $resource = EventReviewResource::class;
}
