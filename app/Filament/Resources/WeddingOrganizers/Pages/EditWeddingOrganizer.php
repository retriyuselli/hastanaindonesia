<?php

namespace App\Filament\Resources\WeddingOrganizers\Pages;

use App\Filament\Resources\WeddingOrganizers\WeddingOrganizerResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWeddingOrganizer extends EditRecord
{
    protected static string $resource = WeddingOrganizerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
