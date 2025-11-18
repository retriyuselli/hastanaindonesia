<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Clusters\ContentCluster;
use App\Filament\Admin\Resources\AuthorResource\Pages;
use App\Filament\Admin\Resources\AuthorResource\Schemas\AuthorForm;
use App\Filament\Admin\Resources\AuthorResource\Tables\AuthorsTable;
use App\Models\Author;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;

    protected static ?string $cluster = ContentCluster::class;

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
