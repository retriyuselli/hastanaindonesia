<?php

namespace App\Filament\Resources\Blogs\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class BlogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->label('Gambar')
                    ->disk('public')
                    ->circular()
                    ->size(40)
                    ->getStateUsing(fn ($record) => filled($record->featured_image) && Storage::disk('public')->exists($record->featured_image) ? $record->featured_image : null)
                    ->defaultImageUrl(asset('images/hastana_logo.png')),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }

                        return $state;
                    }),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->copyable()
                    ->copyMessage('Slug copied!')
                    ->limit(30),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('author.name')
                    ->label('Penulis')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->author?->email),

                TextColumn::make('read_time')
                    ->label('Waktu Baca')
                    ->numeric()
                    ->sortable()
                    ->suffix(' menit')
                    ->alignCenter(),

                TextColumn::make('views_count')
                    ->label('Views')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('success'),

                TextColumn::make('likes_count')
                    ->label('Likes')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('danger'),

                TextColumn::make('comments_count')
                    ->label('Comments')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('warning')
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->alignCenter(),

                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->alignCenter(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'scheduled' => 'info',
                        'archived' => 'danger',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ])->label('Aksi'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ])->label('Aksi'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
