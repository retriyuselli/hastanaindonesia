<?php

namespace App\Filament\Resources\BlogCategories\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class BlogCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(60)
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('color')
                    ->label('Warna')
                    ->html()
                    ->formatStateUsing(function (?string $state): HtmlString {
                        $color = $state ?: '#3B82F6';
                        $safe = e($color);

                        return new HtmlString('<span class="inline-flex items-center gap-2"><span class="w-3 h-3 rounded-full" style="background: '.$safe.'"></span><span class="font-mono">'.$safe.'</span></span>');
                    })
                    ->toggleable(),
                TextColumn::make('icon')
                    ->label('Icon')
                    ->html()
                    ->formatStateUsing(function (?string $state): HtmlString {
                        if (! $state) {
                            return new HtmlString('-');
                        }

                        $value = (string) $state;
                        $safeValue = e($value);

                        if (str_starts_with($value, 'heroicon-')) {
                            return new HtmlString('<span class="font-mono">'.$safeValue.'</span>');
                        }

                        $class = str_contains($value, ' ') ? $value : ('fas fa-'.$value);
                        $safeClass = e($class);

                        return new HtmlString('<span class="inline-flex items-center gap-2"><i class="'.$safeClass.'"></i><span class="font-mono">'.$safeValue.'</span></span>');
                    })
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->alignCenter()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif'),
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
            ->defaultSort('sort_order');
    }
}
