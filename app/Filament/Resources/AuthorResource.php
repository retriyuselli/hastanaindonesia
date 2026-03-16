<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuthorResource\Pages;
use App\Filament\Resources\AuthorResource\Schemas\AuthorForm;
use App\Filament\Resources\AuthorResource\Tables\AuthorsTable;
use App\Models\Author;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    public static function form(Schema $schema): Schema
    {
        return AuthorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AuthorsTable::configure($table);
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
            'index' => Pages\ListAuthors::route('/'),
            'create' => Pages\CreateAuthor::route('/create'),
            'edit' => Pages\EditAuthor::route('/{record}/edit'),
        ];
    }
}
