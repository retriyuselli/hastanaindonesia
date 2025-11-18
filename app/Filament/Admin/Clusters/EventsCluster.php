<?php

namespace App\Filament\Admin\Clusters;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class EventsCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::CalendarDays;
    protected static ?string $navigationLabel = 'Events';
    protected static ?int $navigationSort = 3;
}