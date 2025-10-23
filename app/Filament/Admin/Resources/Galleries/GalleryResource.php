<?php

namespace App\Filament\Admin\Resources\Galleries;

use App\Filament\Admin\Resources\Galleries\Pages\CreateGallery;
use App\Filament\Admin\Resources\Galleries\Pages\EditGallery;
use App\Filament\Admin\Resources\Galleries\Pages\ListGalleries;
use App\Filament\Admin\Resources\Galleries\Pages\ViewGallery;
use App\Filament\Admin\Resources\Galleries\Schemas\GalleryForm;
use App\Filament\Admin\Resources\Galleries\Schemas\GalleryInfolist;
use App\Filament\Admin\Resources\Galleries\Tables\GalleriesTable;
use App\Models\Gallery;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Gallery';

    protected static ?string $modelLabel = 'Gallery';

    protected static ?string $pluralModelLabel = 'Galleries';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return GalleryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GalleryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GalleriesTable::configure($table);
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
            'index' => ListGalleries::route('/'),
            'create' => CreateGallery::route('/create'),
            'view' => ViewGallery::route('/{record}'),
            'edit' => EditGallery::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
