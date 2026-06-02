<?php

namespace App\Filament\Resources\IuranSettings\Pages;

use App\Filament\Resources\IuranSettings\IuranSettingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIuranSetting extends EditRecord
{
    protected static string $resource = IuranSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
