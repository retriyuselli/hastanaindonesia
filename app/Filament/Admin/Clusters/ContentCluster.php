<?php

namespace App\Filament\Admin\Clusters;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class ContentCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::RectangleStack;
    protected static ?string $navigationLabel = 'Content';
    protected static ?int $navigationSort = 4;
}