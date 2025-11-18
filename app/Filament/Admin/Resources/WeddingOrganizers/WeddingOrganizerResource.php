<?php

namespace App\Filament\Admin\Resources\WeddingOrganizers;

use App\Filament\Admin\Clusters\OrganizationCluster;
use App\Filament\Admin\Resources\WeddingOrganizers\Pages\CreateWeddingOrganizer;
use App\Filament\Admin\Resources\WeddingOrganizers\Pages\EditWeddingOrganizer;
use App\Filament\Admin\Resources\WeddingOrganizers\Pages\ListWeddingOrganizers;
use App\Filament\Admin\Resources\WeddingOrganizers\Schemas\WeddingOrganizerForm;
use App\Filament\Admin\Resources\WeddingOrganizers\Tables\WeddingOrganizersTable;
use App\Models\WeddingOrganizer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WeddingOrganizerResource extends Resource
{
    protected static ?string $model = WeddingOrganizer::class;

    protected static ?string $cluster = OrganizationCluster::class;

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
