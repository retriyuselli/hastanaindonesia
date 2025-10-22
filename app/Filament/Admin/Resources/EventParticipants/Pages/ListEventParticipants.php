<?php

namespace App\Filament\Admin\Resources\EventParticipants\Pages;

use App\Filament\Admin\Resources\EventParticipants\EventParticipantResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEventParticipants extends ListRecords
{
    protected static string $resource = EventParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
