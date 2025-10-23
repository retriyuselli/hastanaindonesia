<?php

namespace App\Filament\Admin\Resources\Galleries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GalleriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Gambar')
                    ->square()
                    ->size(80),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->wrap(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Resepsi' => 'info',
                        'Akad Nikah' => 'success',
                        'Outdoor Wedding' => 'warning',
                        'Dekorasi' => 'primary',
                        'Behind The Scenes' => 'gray',
                        'Fashion' => 'danger',
                        default => 'secondary',
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('location')
                    ->label('Lokasi')
                    ->searchable()
                    ->toggleable()
                    ->limit(20),

                TextColumn::make('weddingOrganizer.organizer_name')
                    ->label('Wedding Organizer')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(30),

                TextColumn::make('views_count')
                    ->label('Views')
                    ->numeric()
                    ->sortable()
                    ->alignEnd()
                    ->toggleable(),

                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'Resepsi' => 'Resepsi',
                        'Akad Nikah' => 'Akad Nikah',
                        'Outdoor Wedding' => 'Outdoor Wedding',
                        'Dekorasi' => 'Dekorasi',
                        'Behind The Scenes' => 'Behind The Scenes',
                        'Fashion' => 'Fashion',
                        'Planning' => 'Planning',
                        'Catering' => 'Catering',
                        'Entertainment' => 'Entertainment',
                        'Technical' => 'Technical',
                        'Preparation' => 'Preparation',
                        'Intimate Wedding' => 'Intimate Wedding',
                    ]),

                SelectFilter::make('is_featured')
                    ->label('Featured')
                    ->options([
                        true => 'Yes',
                        false => 'No',
                    ]),

                SelectFilter::make('is_published')
                    ->label('Status')
                    ->options([
                        true => 'Published',
                        false => 'Draft',
                    ]),

                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped();
    }
}
