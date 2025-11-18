<?php

namespace App\Filament\Admin\Resources\Blogs;

use App\Filament\Admin\Clusters\ContentCluster;
use App\Filament\Admin\Resources\Blogs\Pages\CreateBlog;
use App\Filament\Admin\Resources\Blogs\Pages\EditBlog;
use App\Filament\Admin\Resources\Blogs\Pages\ListBlogs;
use App\Filament\Admin\Resources\Blogs\Pages\ViewBlog;
use App\Filament\Admin\Resources\Blogs\Schemas\BlogForm;
use App\Filament\Admin\Resources\Blogs\Schemas\BlogInfolist;
use App\Filament\Admin\Resources\Blogs\Tables\BlogsTable;
use App\Models\Blog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $cluster = ContentCluster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return BlogForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BlogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BlogsTable::configure($table);
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
            'index' => ListBlogs::route('/'),
            'create' => CreateBlog::route('/create'),
            'view' => ViewBlog::route('/{record}'),
            'edit' => EditBlog::route('/{record}/edit'),
        ];
    }
}
