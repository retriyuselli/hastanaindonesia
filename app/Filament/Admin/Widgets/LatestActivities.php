<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Blog;
use App\Models\EventHastana;
use App\Models\EventParticipant;
use App\Models\Member;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestActivities extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $heading = 'Latest Activities';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                EventParticipant::query()
                    ->with(['eventHastana', 'user'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                
                TextColumn::make('name')
                    ->label('Participant')
                    ->searchable()
                    ->weight('bold'),
                
                TextColumn::make('eventHastana.title')
                    ->label('Event')
                    ->searchable()
                    ->limit(30),
                
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'attended' => 'info',
                    }),
                
                TextColumn::make('payment_status')
                    ->label('Payment')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'free' => 'info',
                        'refunded' => 'danger',
                    }),
            ])
            ->paginated(false);
    }
}
