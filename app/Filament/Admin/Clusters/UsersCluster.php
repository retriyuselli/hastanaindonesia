<?php

namespace App\Filament\Admin\Clusters;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class UsersCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;
    protected static ?string $navigationLabel = 'Users';
    protected static ?int $navigationSort = 1;
}