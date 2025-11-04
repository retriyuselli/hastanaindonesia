<?php

namespace App\Filament\Admin\Resources\EventHastanas\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\DatePicker;

class EventHastanasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Event Info
                ImageColumn::make('image')
                    ->label('Gambar')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder-event.jpg'))
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->checkFileExistence(false),

                TextColumn::make('title')
                    ->label('Judul Event')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(40)
                    ->wrap()
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 40) {
                            return null;
                        }
                        return $state;
                    })
                    ->description(fn ($record): ?string => 
                        $record->slug ? '🔗 ' . $record->slug : null
                    )
                    ->copyable()
                    ->copyMessage('Judul disalin!')
                    ->copyMessageDuration(1500),

                TextColumn::make('eventCategory.name')
                    ->label('Kategori')
                    ->badge()
                    ->searchable()
                    ->sortable()
                    ->color(fn ($record) => match ($record->eventCategory?->slug) {
                        'workshop-pelatihan' => 'info',
                        'seminar-talkshow' => 'success',
                        'wedding-expo' => 'danger',
                        'sertifikasi-hastana' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('event_type')
                    ->label('Jenis')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        'internal' => 'primary',
                        'eksternal' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('location_type')
                    ->label('Tipe Lokasi')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'offline' => 'Offline',
                        'online' => 'Online',
                        'hybrid' => 'Hybrid',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'offline' => 'success',
                        'online' => 'info',
                        'hybrid' => 'warning',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'offline' => 'heroicon-m-map-pin',
                        'online' => 'heroicon-m-video-camera',
                        'hybrid' => 'heroicon-m-arrows-right-left',
                        default => 'heroicon-m-map-pin',
                    }),

                TextColumn::make('online_link')
                    ->label('Link Meeting')
                    ->url(fn ($record) => $record->online_link, shouldOpenInNewTab: true)
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->online_link)
                    ->placeholder('Tidak ada link')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->icon('heroicon-m-link')
                    ->color('primary'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'cancelled' => 'Cancelled',
                        'finished' => 'Finished',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'cancelled' => 'danger',
                        'finished' => 'warning',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'draft' => 'heroicon-o-document',
                        'published' => 'heroicon-o-check-circle',
                        'cancelled' => 'heroicon-o-x-circle',
                        'finished' => 'heroicon-o-flag',
                        default => 'heroicon-o-question-mark-circle',
                    }),

                // Date & Location
                TextColumn::make('start_date')
                    ->label('Tanggal Mulai')
                    ->date('d M Y')
                    ->sortable()
                    ->description(fn ($record): string => $record->start_time ? 'Jam: ' . substr($record->start_time, 0, 5) : ''),

                TextColumn::make('end_date')
                    ->label('Tanggal Selesai')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->description(fn ($record): string => $record->end_time ? 'Jam: ' . substr($record->end_time, 0, 5) : ''),

                TextColumn::make('city')
                    ->label('Kota')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-map-pin')
                    ->iconColor('primary')
                    ->description(fn ($record): string => $record->venue ?? '')
                    ->limit(30)
                    ->tooltip(fn ($record): ?string => 
                        $record->venue && strlen($record->venue) > 30 ? $record->venue : null
                    ),

                // Price & Participants
                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable()
                    ->formatStateUsing(fn ($record): string => 
                        $record->is_free ? 'GRATIS' : 'Rp ' . number_format($record->price, 0, ',', '.')
                    )
                    ->color(fn ($record): string => $record->is_free ? 'success' : 'primary')
                    ->weight('bold')
                    ->icon(fn ($record): string => $record->is_free ? 'heroicon-o-gift' : 'heroicon-o-banknotes'),

                TextColumn::make('participants')
                    ->label('Peserta')
                    ->formatStateUsing(fn ($record): HtmlString => new HtmlString(
                        '<div class="flex items-center gap-2">' .
                        '<span class="font-semibold">' . $record->current_participants . '</span>' .
                        '<span class="text-gray-400">/</span>' .
                        '<span>' . ($record->max_participants ?? $record->quota ?? '∞') . '</span>' .
                        '</div>'
                    ))
                    ->description(fn ($record): string => 
                        $record->quota ? 
                        'Sisa: ' . max(0, ($record->max_participants ?? $record->quota) - $record->current_participants) : 
                        'Unlimited'
                    )
                    ->color(function ($record): string {
                        if (!$record->max_participants && !$record->quota) return 'gray';
                        $capacity = $record->max_participants ?? $record->quota;
                        $percentage = ($record->current_participants / $capacity) * 100;
                        
                        if ($percentage >= 90) return 'danger';
                        if ($percentage >= 70) return 'warning';
                        return 'success';
                    })
                    ->icon('heroicon-o-user-group')
                    ->tooltip(function ($record): string {
                        if (!$record->max_participants && !$record->quota) return 'Kuota unlimited';
                        $capacity = $record->max_participants ?? $record->quota;
                        $percentage = round(($record->current_participants / $capacity) * 100);
                        return "Kapasitas terisi {$percentage}%";
                    }),

                // Ratings & Features
                TextColumn::make('rating')
                    ->label('Rating')
                    ->numeric(decimalPlaces: 1)
                    ->sortable()
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->description(fn ($record): string => 
                        $record->total_reviews > 0 ? $record->total_reviews . ' reviews' : 'Belum ada review'
                    )
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->toggleable(),

                IconColumn::make('is_trending')
                    ->label('Trending')
                    ->boolean()
                    ->trueIcon('heroicon-o-fire')
                    ->falseIcon('heroicon-o-fire')
                    ->trueColor('danger')
                    ->falseColor('gray')
                    ->toggleable(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->toggleable(),

                // Organizer Info
                TextColumn::make('organizer_name')
                    ->label('Penyelenggara')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->description(fn ($record): string => 
                        $record->contact_email ?? $record->contact_phone ?? ''
                    ),

                // Timestamps
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->since(),
            ])
            ->defaultSort('start_date', 'desc')
            ->filters([
                SelectFilter::make('event_category_id')
                    ->label('Kategori')
                    ->relationship('eventCategory', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('event_type')
                    ->label('Jenis Event')
                    ->options([
                        'internal' => 'Internal',
                        'eksternal' => 'Eksternal',
                    ]),

                SelectFilter::make('location_type')
                    ->label('Tipe Lokasi')
                    ->options([
                        'offline' => 'Offline',
                        'online' => 'Online',
                        'hybrid' => 'Hybrid',
                    ]),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'cancelled' => 'Cancelled',
                        'finished' => 'Finished',
                    ])
                    ->multiple(),

                TernaryFilter::make('is_free')
                    ->label('Event Gratis')
                    ->placeholder('Semua Event')
                    ->trueLabel('Event Gratis')
                    ->falseLabel('Event Berbayar'),

                TernaryFilter::make('is_featured')
                    ->label('Featured')
                    ->placeholder('Semua')
                    ->trueLabel('Featured')
                    ->falseLabel('Non Featured'),

                TernaryFilter::make('is_trending')
                    ->label('Trending')
                    ->placeholder('Semua')
                    ->trueLabel('Trending')
                    ->falseLabel('Non Trending'),

                TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Non Aktif'),

                SelectFilter::make('city')
                    ->label('Kota')
                    ->options(function () {
                        return \App\Models\EventHastana::query()
                            ->distinct()
                            ->pluck('city', 'city')
                            ->filter()
                            ->sort();
                    })
                    ->searchable(),

                SelectFilter::make('date_range')
                    ->label('Periode')
                    ->options([
                        'today' => 'Hari Ini',
                        'this_week' => 'Minggu Ini',
                        'this_month' => 'Bulan Ini',
                        'upcoming' => 'Mendatang',
                        'past' => 'Sudah Lewat',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value'] ?? null) {
                            'today' => $query->whereDate('start_date', today()),
                            'this_week' => $query->whereBetween('start_date', [
                                now()->startOfWeek(),
                                now()->endOfWeek(),
                            ]),
                            'this_month' => $query->whereBetween('start_date', [
                                now()->startOfMonth(),
                                now()->endOfMonth(),
                            ]),
                            'upcoming' => $query->where('start_date', '>=', now()),
                            'past' => $query->where('end_date', '<', now()),
                            default => $query,
                        };
                    }),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Lihat')
                    ->icon('heroicon-o-eye'),
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil'),
                Action::make('viewOnSite')
                    ->label('Lihat di Website')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('success')
                    ->url(fn ($record): string => route('events.show', $record->slug))
                    ->openUrlInNewTab(),
                Action::make('toggleFeatured')
                    ->label(fn ($record): string => $record->is_featured ? 'Hapus Featured' : 'Set Featured')
                    ->icon(fn ($record): string => $record->is_featured ? 'heroicon-o-star' : 'heroicon-s-star')
                    ->color(fn ($record): string => $record->is_featured ? 'warning' : 'gray')
                    ->action(function ($record) {
                        $record->update(['is_featured' => !$record->is_featured]);
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Ubah Status Featured')
                    ->modalDescription(fn ($record): string => 
                        $record->is_featured 
                            ? 'Event ini akan dihapus dari daftar featured.' 
                            : 'Event ini akan ditampilkan sebagai featured.'
                    ),
                Action::make('duplicate')
                    ->label('Duplikat')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $newEvent = $record->replicate();
                        $newEvent->title = $record->title . ' (Copy)';
                        $newEvent->slug = $record->slug . '-copy-' . time();
                        $newEvent->status = 'draft';
                        $newEvent->is_featured = false;
                        $newEvent->is_trending = false;
                        $newEvent->save();
                    })
                    ->successNotificationTitle('Event berhasil diduplikat!')
                    ->modalHeading('Duplikat Event')
                    ->modalDescription('Event akan diduplikat sebagai draft.'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Terpilih'),
                    BulkAction::make('publish')
                        ->label('Publish Terpilih')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each->update(['status' => 'published', 'is_active' => true]);
                        })
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation(),
                    BulkAction::make('draft')
                        ->label('Set Draft Terpilih')
                        ->icon('heroicon-o-document')
                        ->color('gray')
                        ->action(function ($records) {
                            $records->each->update(['status' => 'draft']);
                        })
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation(),
                    BulkAction::make('setFeatured')
                        ->label('Set Featured')
                        ->icon('heroicon-o-star')
                        ->color('warning')
                        ->action(function ($records) {
                            $records->each->update(['is_featured' => true]);
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('removeFeatured')
                        ->label('Hapus Featured')
                        ->icon('heroicon-o-star')
                        ->color('gray')
                        ->action(function ($records) {
                            $records->each->update(['is_featured' => false]);
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->poll('30s')
            ->deferLoading()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession()
            ->persistSortInSession()
            ->persistFiltersInSession();
    }
}
