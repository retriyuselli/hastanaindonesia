<?php

namespace App\Filament\Resources\WeddingOrganizers;

use App\Filament\Resources\WeddingOrganizers\Pages\CreateWeddingOrganizer;
use App\Filament\Resources\WeddingOrganizers\Pages\EditWeddingOrganizer;
use App\Filament\Resources\WeddingOrganizers\Pages\ListWeddingOrganizers;
use App\Filament\Resources\WeddingOrganizers\Schemas\WeddingOrganizerForm;
use App\Filament\Resources\WeddingOrganizers\Tables\WeddingOrganizersTable;
use App\Models\WeddingOrganizer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class WeddingOrganizerResource extends Resource
{
    protected static ?string $model = WeddingOrganizer::class;

    protected static string|UnitEnum|null $navigationGroup = 'Organization';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookmarkSlash;

    protected static ?string $recordTitleAttribute = 'Wedding Organizer';

    public static function form(Schema $schema): Schema
    {
        return WeddingOrganizerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WeddingOrganizersTable::configure($table);
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
            'index' => ListWeddingOrganizers::route('/'),
            'create' => CreateWeddingOrganizer::route('/create'),
            'edit' => EditWeddingOrganizer::route('/{record}/edit'),
        ];
    }
}
