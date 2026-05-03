<?php

namespace App\Filament\Resources\HomeHeroImages;

use App\Filament\Resources\HomeHeroImages\Pages\CreateHomeHeroImage;
use App\Filament\Resources\HomeHeroImages\Pages\EditHomeHeroImage;
use App\Filament\Resources\HomeHeroImages\Pages\ListHomeHeroImages;
use App\Models\HomeHeroImage;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use UnitEnum;

class HomeHeroImageResource extends Resource
{
    protected static ?string $model = HomeHeroImage::class;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'Banner Home';

    protected static ?string $modelLabel = 'Banner Home';

    protected static ?string $pluralModelLabel = 'Banner Home';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Gambar')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Image')
                            ->image()
                            ->disk('public')
                            ->directory('home-hero')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '21:9',
                            ])
                            ->maxSize(5120)
                            ->required()
                            ->downloadable()
                            ->openable()
                            ->imagePreviewHeight('250')
                            ->columnSpanFull(),
                    ]),
                Section::make('Pengaturan')
                    ->schema([
                        TextInput::make('alt')
                            ->label('Alt Text')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('link')
                            ->label('Link')
                            ->url()
                            ->maxLength(2048)
                            ->columnSpanFull(),
                        TextInput::make('sort_order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->size(60)
                    ->getStateUsing(fn ($record) => filled($record->image) && Storage::disk('public')->exists($record->image) ? $record->image : null)
                    ->defaultImageUrl(asset('images/hastana_logo.png')),
                TextColumn::make('alt')
                    ->label('Alt')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('link')
                    ->label('Link')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Update')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Aktif'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHomeHeroImages::route('/'),
            'create' => CreateHomeHeroImage::route('/create'),
            'edit' => EditHomeHeroImage::route('/{record}/edit'),
        ];
    }
}
