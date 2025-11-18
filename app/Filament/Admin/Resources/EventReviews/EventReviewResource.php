<?php

namespace App\Filament\Admin\Resources\EventReviews;

use App\Filament\Admin\Clusters\EventsCluster;
use App\Filament\Admin\Resources\EventReviews\Pages\CreateEventReview;
use App\Filament\Admin\Resources\EventReviews\Pages\EditEventReview;
use App\Filament\Admin\Resources\EventReviews\Pages\ListEventReviews;
use App\Filament\Admin\Resources\EventReviews\Schemas\EventReviewForm;
use App\Filament\Admin\Resources\EventReviews\Tables\EventReviewsTable;
use App\Models\EventReview;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EventReviewResource extends Resource
{
    protected static ?string $model = EventReview::class;

    protected static ?string $cluster = EventsCluster::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'Event Reviews';

    protected static ?string $modelLabel = 'Event Review';

    protected static ?string $pluralModelLabel = 'Event Reviews';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return EventReviewForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventReviewsTable::configure($table);
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
            'index' => ListEventReviews::route('/'),
            'create' => CreateEventReview::route('/create'),
            'edit' => EditEventReview::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_approved', false)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::where('is_approved', false)->count() > 0 ? 'warning' : 'success';
    }
}
