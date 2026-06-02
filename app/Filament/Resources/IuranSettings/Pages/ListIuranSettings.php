<?php

namespace App\Filament\Resources\IuranSettings\Pages;

use App\Filament\Resources\IuranSettings\IuranSettingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIuranSettings extends ListRecords
{
    protected static string $resource = IuranSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
