<?php

namespace App\Filament\Resources\EventReviews;

use App\Filament\Resources\EventReviews\Pages\CreateEventReview;
use App\Filament\Resources\EventReviews\Pages\EditEventReview;
use App\Filament\Resources\EventReviews\Pages\ListEventReviews;
use App\Filament\Resources\EventReviews\Schemas\EventReviewForm;
use App\Filament\Resources\EventReviews\Tables\EventReviewsTable;
use App\Models\EventReview;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class EventReviewResource extends Resource
{
    protected static ?string $model = EventReview::class;

    protected static string|UnitEnum|null $navigationGroup = 'Events';

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
