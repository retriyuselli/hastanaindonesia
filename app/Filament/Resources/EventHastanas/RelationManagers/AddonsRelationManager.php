<?php

namespace App\Filament\Resources\EventHastanas\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AddonsRelationManager extends RelationManager
{
    protected static string $relationship = 'addons';

    protected static ?string $title = 'Addon';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nama Addon')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            Textarea::make('description')
                ->label('Deskripsi')
                ->rows(2)
                ->columnSpanFull(),

            TextInput::make('price')
                ->label('Harga (Rp)')
                ->numeric()
                ->prefix('Rp')
                ->required()
                ->default(0)
                ->minValue(0),

            TextInput::make('quota')
                ->label('Kuota (kosongkan = unlimited)')
                ->numeric()
                ->minValue(1)
                ->nullable(),

            TextInput::make('sort_order')
                ->label('Urutan Tampil')
                ->numeric()
                ->default(0),

            Toggle::make('is_active')
                ->label('Aktif')
                ->default(true),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable()
                    ->width('50px'),

                TextColumn::make('name')
                    ->label('Nama Addon')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('quota')
                    ->label('Kuota')
                    ->formatStateUsing(fn($state) => $state ?? 'Unlimited')
                    ->sortable(),

                TextColumn::make('ordered_quantity')
                    ->label('Dipesan')
                    ->getStateUsing(fn($record) => $record->ordered_quantity),

                TextColumn::make('remaining_quota')
                    ->label('Sisa')
                    ->getStateUsing(fn($record) => $record->remaining_quota ?? 'Unlimited')
                    ->color(fn($record) => $record->quota !== null && $record->remaining_quota <= 0 ? 'danger' : 'success'),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->headerActions([
                CreateAction::make()->label('Tambah Addon'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
