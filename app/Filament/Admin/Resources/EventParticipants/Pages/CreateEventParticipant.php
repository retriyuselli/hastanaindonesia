<?php

namespace App\Filament\Admin\Resources\EventParticipants\Pages;

use App\Filament\Admin\Resources\EventParticipants\EventParticipantResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEventParticipant extends CreateRecord
{
    protected static string $resource = EventParticipantResource::class;
}
