<?php

namespace App\Filament\Admin\Resources\EventHastanas\Pages;

use App\Filament\Admin\Resources\EventHastanas\EventHastanaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEventHastanas extends ListRecords
{
    protected static string $resource = EventHastanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
