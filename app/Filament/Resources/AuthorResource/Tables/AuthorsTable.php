<?php

namespace App\Filament\Resources\AuthorResource\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class AuthorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->label('Avatar')
                    ->disk('public')
                    ->circular()
                    ->getStateUsing(fn ($record) => filled($record->avatar) && Storage::disk('public')->exists($record->avatar) ? $record->avatar : null)
                    ->defaultImageUrl(asset('images/default-avatar.png')),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Slug disalin!')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-envelope')
                    ->copyable(),

                TextColumn::make('blogs_count')
                    ->counts('blogs')
                    ->label('Total Blogs')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('info'),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->alignCenter(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
                TernaryFilter::make('has_blogs')
                    ->label('Punya Blog')
                    ->placeholder('Semua')
                    ->trueLabel('Ya')
                    ->falseLabel('Tidak')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereHas('blogs'),
                        false: fn (Builder $query): Builder => $query->whereDoesntHave('blogs'),
                    ),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
