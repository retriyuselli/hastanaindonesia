<?php

namespace App\Filament\Admin\Resources\EventHastanas\Pages;

use App\Filament\Admin\Resources\EventHastanas\EventHastanaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEventHastana extends ViewRecord
{
    protected static string $resource = EventHastanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
