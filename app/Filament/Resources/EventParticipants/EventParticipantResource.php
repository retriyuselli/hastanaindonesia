<?php

namespace App\Filament\Resources\EventParticipants;

use App\Filament\Resources\EventParticipants\Pages\CreateEventParticipant;
use App\Filament\Resources\EventParticipants\Pages\EditEventParticipant;
use App\Filament\Resources\EventParticipants\Pages\ListEventParticipants;
use App\Filament\Resources\EventParticipants\Pages\ViewEventParticipant;
use App\Filament\Resources\EventParticipants\Schemas\EventParticipantForm;
use App\Filament\Resources\EventParticipants\Schemas\EventParticipantInfolist;
use App\Filament\Resources\EventParticipants\Tables\EventParticipantsTable;
use App\Models\EventParticipant;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EventParticipantResource extends Resource
{
    protected static ?string $model = EventParticipant::class;

    protected static string|UnitEnum|null $navigationGroup = 'Events';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTicket;

    public static function form(Schema $schema): Schema
    {
        return EventParticipantForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EventParticipantInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventParticipantsTable::configure($table);
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
            'index' => ListEventParticipants::route('/'),
            'create' => CreateEventParticipant::route('/create'),
            'view' => ViewEventParticipant::route('/{record}'),
            'edit' => EditEventParticipant::route('/{record}/edit'),
        ];
    }
}
