<?php

namespace App\Filament\Admin\Resources\EventHastanas\Pages;

use App\Filament\Admin\Resources\EventHastanas\EventHastanaResource;
use App\Filament\Admin\Resources\EventHastanas\Widgets\EventStatsOverview;
use App\Filament\Admin\Resources\EventHastanas\Widgets\EventParticipantChart;
use App\Filament\Admin\Resources\EventHastanas\Widgets\EventRevenueChart;
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
