<?php

namespace App\Filament\Admin\Resources\EventParticipants\Pages;

use App\Filament\Admin\Resources\EventParticipants\EventParticipantResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEventParticipant extends ViewRecord
{
    protected static string $resource = EventParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
