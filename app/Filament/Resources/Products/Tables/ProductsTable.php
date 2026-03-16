<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('images')
                    ->label('Gambar')
                    ->circular()
                    ->stacked()
                    ->limit(3),

                TextColumn::make('weddingOrganizer.organizer_name')
                    ->label('Wedding Organizer')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('original_price')
                    ->label('Harga Asli')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Harga Jual')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('discount')
                    ->label('Diskon')
                    ->money('IDR')
                    ->sortable()
                    ->color('success'),

                IconColumn::make('limited_offer')
                    ->label('Limited')
                    ->boolean()
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

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

                TextColumn::make('deleted_at')
                    ->label('Dihapus')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),

                SelectFilter::make('wedding_organizer_id')
                    ->label('Wedding Organizer')
                    ->relationship('weddingOrganizer', 'organizer_name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('limited_offer')
                    ->label('Limited Offer')
                    ->options([
                        1 => 'Ya',
                        0 => 'Tidak',
                    ]),

                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        1 => 'Aktif',
                        0 => 'Tidak Aktif',
                    ]),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make()
                        ->visible(fn ($record) => ! method_exists($record, 'trashed') || ! $record->trashed()),
                    RestoreAction::make()
                        ->visible(fn ($record) => method_exists($record, 'trashed') && $record->trashed()),
                    ForceDeleteAction::make()
                        ->visible(fn ($record) => method_exists($record, 'trashed') && $record->trashed()),
                ])->label('Aksi'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ])->label('Aksi'),
            ])
            ->defaultSort('sort_order', 'asc');
    }
}
