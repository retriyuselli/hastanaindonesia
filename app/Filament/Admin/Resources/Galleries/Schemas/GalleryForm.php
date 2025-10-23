<?php

namespace App\Filament\Admin\Resources\Galleries\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Informasi Utama')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, $set) => 
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                            ),

                        TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->disabled()
                            ->dehydrated(),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(4)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(2),

                Section::make('Media & Kategori')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Gambar')
                            ->image()
                            ->disk('public')
                            ->directory('galleries')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                                '4:3',
                                '16:9',
                            ])
                            ->maxSize(5120)
                            ->required()
                            ->helperText('Upload gambar (max 5MB)'),

                        Select::make('category')
                            ->label('Kategori')
                            ->required()
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
                            ])
                            ->searchable(),

                        TagsInput::make('tags')
                            ->label('Tags')
                            ->placeholder('Tambah tag')
                            ->helperText('Tekan Enter untuk menambah tag'),
                    ])
                    ->columnSpan(1),

                Section::make('Detail Event')
                    ->schema([
                        DatePicker::make('date')
                            ->label('Tanggal Event')
                            ->displayFormat('d/m/Y')
                            ->native(false),

                        TextInput::make('location')
                            ->label('Lokasi')
                            ->maxLength(255),

                        TextInput::make('photographer')
                            ->label('Photographer')
                            ->maxLength(255)
                            ->default('HASTANA Photography Team'),

                        Select::make('wedding_organizer_id')
                            ->label('Wedding Organizer')
                            ->relationship('weddingOrganizer', 'organizer_name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText('Pilih WO jika gallery ini milik member'),
                    ])
                    ->columns(2)
                    ->columnSpan(2),

                Section::make('Pengaturan')
                    ->schema([
                        TextInput::make('views_count')
                            ->label('Jumlah Views')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->dehydrated(),

                        Toggle::make('is_featured')
                            ->label('Featured')
                            ->helperText('Tampilkan di halaman utama')
                            ->default(false),

                        Toggle::make('is_published')
                            ->label('Published')
                            ->helperText('Publikasikan gallery ini')
                            ->default(true),
                    ])
                    ->columns(3)
                    ->columnSpan(1),
            ]);
    }
}
