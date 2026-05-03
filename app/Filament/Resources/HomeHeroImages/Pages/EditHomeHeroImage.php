<?php

namespace App\Filament\Resources\HomeHeroImages\Pages;

use App\Filament\Resources\HomeHeroImages\HomeHeroImageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHomeHeroImage extends EditRecord
{
    protected static string $resource = HomeHeroImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

