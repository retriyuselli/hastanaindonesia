<?php

namespace App\Filament\Admin\Resources\BlogCategories;

use App\Filament\Admin\Resources\BlogCategories\Pages\CreateBlogCategory;
use App\Filament\Admin\Resources\BlogCategories\Pages\EditBlogCategory;
use App\Filament\Admin\Resources\BlogCategories\Pages\ListBlogCategories;
use App\Filament\Admin\Resources\BlogCategories\Pages\ViewBlogCategory;
use App\Filament\Admin\Resources\BlogCategories\Schemas\BlogCategoryForm;
use App\Filament\Admin\Resources\BlogCategories\Schemas\BlogCategoryInfolist;
use App\Filament\Admin\Resources\BlogCategories\Tables\BlogCategoriesTable;
use App\Models\BlogCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BlogCategoryResource extends Resource
{
    protected static ?string $model = BlogCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return BlogCategoryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BlogCategoryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BlogCategoriesTable::configure($table);
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
            'index' => ListBlogCategories::route('/'),
            'create' => CreateBlogCategory::route('/create'),
            'view' => ViewBlogCategory::route('/{record}'),
            'edit' => EditBlogCategory::route('/{record}/edit'),
        ];
    }
}
