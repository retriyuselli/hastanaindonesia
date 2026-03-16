<?php

namespace App\Filament\Resources\EventHastanas\Pages;

use App\Filament\Resources\EventHastanas\EventHastanaResource;
use App\Filament\Resources\EventHastanas\Widgets\EventParticipantChart;
use App\Filament\Resources\EventHastanas\Widgets\EventRevenueChart;
use App\Filament\Resources\EventHastanas\Widgets\EventStatsOverview;
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

    protected function getHeaderWidgets(): array
    {
        return [
            EventStatsOverview::class,
            EventParticipantChart::class,
            EventRevenueChart::class,
        ];
    }
}
