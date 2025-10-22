<?php

namespace App\Filament\Admin\Resources\EventHastanas;

use App\Filament\Admin\Resources\EventHastanas\Pages\CreateEventHastana;
use App\Filament\Admin\Resources\EventHastanas\Pages\EditEventHastana;
use App\Filament\Admin\Resources\EventHastanas\Pages\ListEventHastanas;
use App\Filament\Admin\Resources\EventHastanas\Pages\ViewEventHastana;
use App\Filament\Admin\Resources\EventHastanas\Schemas\EventHastanaForm;
use App\Filament\Admin\Resources\EventHastanas\Schemas\EventHastanaInfolist;
use App\Filament\Admin\Resources\EventHastanas\Tables\EventHastanasTable;
use App\Models\EventHastana;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EventHastanaResource extends Resource
{
    protected static ?string $model = EventHastana::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return EventHastanaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EventHastanaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventHastanasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
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
