<?php

namespace App\Filament\Admin\Resources\BlogComments\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class BlogCommentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('blog.title')
                    ->label('Blog Article')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->url(fn ($record) => $record->blog ? route('blog.detail', $record->blog->slug) : null)
                    ->openUrlInNewTab(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),
                TextColumn::make('comment')
                    ->label('Comment')
                    ->limit(50)
                    ->searchable()
                    ->wrap(),
                IconColumn::make('is_approved')
                    ->label('Approved')
                    ->boolean()
                    ->sortable()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('warning'),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('ip_address')
                    ->label('IP')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TernaryFilter::make('is_approved')
                    ->label('Approval Status')
                    ->placeholder('All comments')
                    ->trueLabel('Approved only')
                    ->falseLabel('Pending only'),
                Filter::make('recent')
                    ->label('Recent (7 days)')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->subDays(7))),
                Filter::make('this_month')
                    ->label('This Month')
                    ->query(fn (Builder $query): Builder => $query->whereMonth('created_at', now()->month)),
                SelectFilter::make('blog_id')
                    ->label('Blog Article')
                    ->relationship('blog', 'title')
                    ->searchable()
                    ->preload(),
            ])
            ->headerActions([
                Action::make('stats')
                    ->label('Statistics')
                    ->icon('heroicon-o-chart-bar')
                    ->color('info')
                    ->modalContent(function () {
                        $total = \App\Models\BlogComment::count();
                        $approved = \App\Models\BlogComment::where('is_approved', true)->count();
                        $pending = \App\Models\BlogComment::where('is_approved', false)->count();
                        $today = \App\Models\BlogComment::whereDate('created_at', today())->count();
                        $thisWeek = \App\Models\BlogComment::where('created_at', '>=', now()->subDays(7))->count();
                        
                        return view('filament.admin.resources.blog-comments.stats', compact(
                            'total', 'approved', 'pending', 'today', 'thisWeek'
                        ));
                    })
                    ->modalWidth('md')
                    ->slideOver(),
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['is_approved' => true]))
                    ->visible(fn ($record) => !$record->is_approved),
                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['is_approved' => false]))
                    ->visible(fn ($record) => $record->is_approved),
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('approve')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->update(['is_approved' => true])),
                    BulkAction::make('reject')
                        ->label('Reject Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->update(['is_approved' => false])),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
