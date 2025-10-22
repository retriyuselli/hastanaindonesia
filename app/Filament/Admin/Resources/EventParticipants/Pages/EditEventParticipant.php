<?php

namespace App\Filament\Admin\Resources\EventParticipants\Pages;

use App\Filament\Admin\Resources\EventParticipants\EventParticipantResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditEventParticipant extends EditRecord
{
    protected static string $resource = EventParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
