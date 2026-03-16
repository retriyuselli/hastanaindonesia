<?php

namespace App\Filament\Resources\AboutPages;

use App\Filament\Resources\AboutPages\Pages\CreateAboutPage;
use App\Filament\Resources\AboutPages\Pages\EditAboutPage;
use App\Filament\Resources\AboutPages\Pages\ListAboutPages;
use App\Filament\Resources\AboutPages\Pages\ViewAboutPage;
use App\Filament\Resources\AboutPages\Schemas\AboutPageForm;
use App\Filament\Resources\AboutPages\Schemas\AboutPageInfolist;
use App\Filament\Resources\AboutPages\Tables\AboutPagesTable;
use App\Models\AboutPage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AboutPageResource extends Resource
{
    protected static ?string $model = AboutPage::class;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Tentang Kami';

    protected static ?string $modelLabel = 'Halaman Tentang Kami';

    protected static ?string $pluralModelLabel = 'Halaman Tentang Kami';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return AboutPageForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AboutPageInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AboutPagesTable::configure($table);
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
            'index' => ListAboutPages::route('/'),
            'create' => CreateAboutPage::route('/create'),
            'view' => ViewAboutPage::route('/{record}'),
            'edit' => EditAboutPage::route('/{record}/edit'),
        ];
    }
}
