<?php

namespace App\Filament\Admin\Resources\BlogComments;

use App\Filament\Admin\Resources\BlogComments\Pages\CreateBlogComment;
use App\Filament\Admin\Resources\BlogComments\Pages\EditBlogComment;
use App\Filament\Admin\Resources\BlogComments\Pages\ListBlogComments;
use App\Filament\Admin\Resources\BlogComments\Pages\ViewBlogComment;
use App\Filament\Admin\Resources\BlogComments\Schemas\BlogCommentForm;
use App\Filament\Admin\Resources\BlogComments\Schemas\BlogCommentInfolist;
use App\Filament\Admin\Resources\BlogComments\Tables\BlogCommentsTable;
use App\Models\BlogComment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BlogCommentResource extends Resource
{
    protected static ?string $model = BlogComment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?string $navigationLabel = 'Blog Comments';

    protected static ?string $modelLabel = 'Comment';

    protected static ?string $pluralModelLabel = 'Comments';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_approved', false)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $pendingCount = static::getModel()::where('is_approved', false)->count();
        return $pendingCount > 10 ? 'danger' : ($pendingCount > 0 ? 'warning' : null);
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        $pendingCount = static::getModel()::where('is_approved', false)->count();
        return $pendingCount > 0 ? "{$pendingCount} pending approval" : null;
    }

    public static function form(Schema $schema): Schema
    {
        return BlogCommentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BlogCommentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BlogCommentsTable::configure($table);
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
            'index' => ListBlogComments::route('/'),
            'create' => CreateBlogComment::route('/create'),
            'view' => ViewBlogComment::route('/{record}'),
            'edit' => EditBlogComment::route('/{record}/edit'),
        ];
    }
}
