<?php

namespace App\Filament\Resources\EventHastanas;

use App\Filament\Resources\EventHastanas\Pages\CreateEventHastana;
use App\Filament\Resources\EventHastanas\Pages\EditEventHastana;
use App\Filament\Resources\EventHastanas\Pages\ListEventHastanas;
use App\Filament\Resources\EventHastanas\Pages\ViewEventHastana;
use App\Filament\Resources\EventHastanas\RelationManagers\EventParticipantsRelationManager;
use App\Filament\Resources\EventHastanas\Schemas\EventHastanaForm;
use App\Filament\Resources\EventHastanas\Tables\EventHastanasTable;
use App\Filament\Resources\EventHastanas\Widgets\EventParticipantChart;
use App\Filament\Resources\EventHastanas\Widgets\EventRevenueChart;
use App\Filament\Resources\EventHastanas\Widgets\EventStatsOverview;
use App\Models\EventHastana;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EventHastanaResource extends Resource
{
    protected static ?string $model = EventHastana::class;

    protected static string|UnitEnum|null $navigationGroup = 'Events';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    public static function form(Schema $schema): Schema
    {
        return EventHastanaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->schema([]);
    }

    public static function table(Table $table): Table
    {
        return EventHastanasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            EventParticipantsRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            EventStatsOverview::class,
            EventParticipantChart::class,
            EventRevenueChart::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEventHastanas::route('/'),
            'create' => CreateEventHastana::route('/create'),
            'view' => ViewEventHastana::route('/{record}'),
            'edit' => EditEventHastana::route('/{record}/edit'),
        ];
    }
}
