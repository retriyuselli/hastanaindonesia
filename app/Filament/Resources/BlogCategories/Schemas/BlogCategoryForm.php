<?php

namespace App\Filament\Resources\BlogCategories\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BlogCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->label('🏷️ Nama Kategori')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Tips & Trik, Inspirasi, Vendor, dll.')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, $set) {
                        if ($operation !== 'create') {
                            return;
                        }

                        $set('slug', Str::slug((string) $state));
                    }),
                TextInput::make('slug')
                    ->label('🔗 Slug URL')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('tips-trik')
                    ->unique(ignoreRecord: true)
                    ->suffixIcon('heroicon-m-link')
                    ->rules(['alpha_dash'])
                    ->validationMessages([
                        'alpha_dash' => 'Slug hanya boleh mengandung huruf, angka, dash (-) dan underscore (_)',
                    ]),
                Textarea::make('description')
                    ->label('📝 Deskripsi')
                    ->placeholder('Deskripsi singkat kategori blog...')
                    ->rows(3)
                    ->columnSpanFull(),
                ColorPicker::make('color')
                    ->label('🌈 Warna')
                    ->required()
                    ->default('#3B82F6')
                    ->helperText('Warna untuk label/badge kategori'),
                Select::make('icon')
                    ->label('🎯 Icon')
                    ->options([
                        'folder' => '📁 Folder',
                        'tags' => '🏷️ Tags',
                        'newspaper' => '📰 News',
                        'lightbulb' => '💡 Tips',
                        'heart' => '❤️ Inspirasi',
                        'briefcase' => '💼 Vendor',
                        'camera' => '📷 Foto',
                        'bullhorn' => '📣 Info',
                        'star' => '⭐ Highlight',
                        'book' => '📚 Panduan',
                    ])
                    ->default('folder')
                    ->searchable()
                    ->placeholder('Pilih icon'),
                Toggle::make('is_active')
                    ->label('✅ Status Aktif')
                    ->required()
                    ->default(true)
                    ->onIcon('heroicon-m-check-circle')
                    ->offIcon('heroicon-m-x-circle')
                    ->onColor('success')
                    ->offColor('danger'),
                TextInput::make('sort_order')
                    ->label('🔢 Urutan Tampilan')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->maxValue(999)
                    ->step(1)
                    ->placeholder('0')
                    ->helperText('Semakin kecil angka, semakin atas posisinya'),
            ]);
    }
}
