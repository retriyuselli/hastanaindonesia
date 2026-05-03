<?php

namespace App\Filament\Resources\HomeHeroImages\Pages;

use App\Filament\Resources\HomeHeroImages\HomeHeroImageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHomeHeroImages extends ListRecords
{
    protected static string $resource = HomeHeroImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

