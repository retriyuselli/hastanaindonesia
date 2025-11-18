<?php

namespace App\Filament\Admin\Clusters;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class OrganizationCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::HomeModern;
    protected static ?string $navigationLabel = 'Organization';
    protected static ?int $navigationSort = 2;
}