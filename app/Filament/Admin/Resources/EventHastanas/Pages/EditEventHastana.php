<?php

namespace App\Filament\Admin\Resources\EventHastanas\Pages;

use App\Filament\Admin\Resources\EventHastanas\EventHastanaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditEventHastana extends EditRecord
{
    protected static string $resource = EventHastanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
