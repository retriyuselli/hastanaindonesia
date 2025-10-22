<?php

namespace App\Filament\Admin\Resources\EventHastanas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class EventHastanaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                
                TextInput::make('title')
                    ->label('Judul Event')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($get, $set, ?string $state) {
                        if (!$get('slug') || $get('slug') === Str::slug($get('title'))) {
                            $set('slug', Str::slug($state));
                        }
                    })
                    ->placeholder('Contoh: Workshop Photography Masterclass')
                    ->helperText('Judul menarik untuk event Anda')
                    ->columnSpanFull(),
                
                TextInput::make('slug')
                    ->label('Slug URL')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->placeholder('workshop-photography-masterclass')
                    ->helperText('URL-friendly (auto dari title)')
                    ->columnSpanFull(),
                
                Select::make('event_category_id')
                    ->label('Kategori Event')
                    ->relationship('eventCategory', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->placeholder('Pilih kategori'),
                
                Select::make('event_type')
                    ->label('Tipe Event')
                    ->options([
                        'internal' => 'Internal',
                        'eksternal' => 'Eksternal',
                    ])
                    ->required()
                    ->default('internal')
                    ->native(false),
                
                Select::make('location_type')
                    ->label('Tipe Lokasi')
                    ->options([
                        'offline' => 'Offline (Lokasi Fisik)',
                        'online' => 'Online (Virtual)',
                        'hybrid' => 'Hybrid (Offline & Online)',
                    ])
                    ->required()
                    ->default('offline')
                    ->native(false)
                    ->live()
                    ->helperText('Pilih tipe lokasi kegiatan'),
                
                TextInput::make('online_link')
                    ->label('Link Meeting Online')
                    ->url()
                    ->placeholder('https://zoom.us/j/123456789 atau https://meet.google.com/xxx-xxxx-xxx')
                    ->helperText('Link Zoom, Google Meet, atau platform online lainnya')
                    ->columnSpanFull()
                    ->visible(fn ($get) => in_array($get('location_type'), ['online', 'hybrid']))
                    ->required(fn ($get) => $get('location_type') === 'online'),
                
                RichEditor::make('description')
                    ->label('Deskripsi Lengkap')
                    ->required()
                    ->columnSpanFull(),
                
                Textarea::make('short_description')
                    ->label('Deskripsi Singkat')
                    ->rows(3)
                    ->columnSpanFull(),
                
                FileUpload::make('image')
                    ->label('Gambar Event')
                    ->image()
                    ->disk('public')
                    ->directory('events')
                    ->maxSize(2048)
                    ->columnSpanFull(),
                
                DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->required()
                    ->native(false),
                
                DatePicker::make('end_date')
                    ->label('Tanggal Selesai')
                    ->required()
                    ->native(false),
                
                TimePicker::make('start_time')
                    ->label('Waktu Mulai')
                    ->seconds(false),
                
                TimePicker::make('end_time')
                    ->label('Waktu Selesai')
                    ->seconds(false),
                
                TextInput::make('location')
                    ->label('Alamat Lokasi')
                    ->placeholder('Jl. Contoh No. 123, Gedung ABC')
                    ->helperText('Alamat lengkap tempat pelaksanaan event')
                    ->required(fn ($get) => in_array($get('location_type'), ['offline', 'hybrid']))
                    ->hidden(fn ($get) => $get('location_type') === 'online'),
                
                TextInput::make('venue')
                    ->label('Nama Venue')
                    ->placeholder('Gedung Serbaguna, Aula Utama, dll')
                    ->hidden(fn ($get) => $get('location_type') === 'online'),
                
                TextInput::make('city')
                    ->label('Kota')
                    ->placeholder('Jakarta, Bandung, dll')
                    ->required(fn ($get) => in_array($get('location_type'), ['offline', 'hybrid']))
                    ->hidden(fn ($get) => $get('location_type') === 'online'),
                
                TextInput::make('province')
                    ->label('Provinsi')
                    ->placeholder('DKI Jakarta, Jawa Barat, dll')
                    ->hidden(fn ($get) => $get('location_type') === 'online'),
                
                Toggle::make('is_free')
                    ->label('Event Gratis')
                    ->default(false)
                    ->live()
                    ->columnSpanFull(),
                
                TextInput::make('price')
                    ->label('Harga')
                    ->numeric()
                    ->prefix('Rp')
                    ->hidden(fn ($get) => $get('is_free') === true)
                    ->required(fn ($get) => $get('is_free') === false),
                
                TextInput::make('max_participants')
                    ->label('Maksimal Peserta')
                    ->numeric()
                    ->minValue(1)
                    ->placeholder('Contoh: 100')
                    ->helperText('Jumlah maksimal peserta yang dapat mendaftar'),
                
                TextInput::make('current_participants')
                    ->label('Peserta Terdaftar')
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->helperText('Auto-update dari registrasi'),
                
                Textarea::make('benefits')
                    ->label('Benefit')
                    ->rows(4)
                    ->columnSpanFull(),
                
                Textarea::make('requirements')
                    ->label('Persyaratan')
                    ->rows(4)
                    ->columnSpanFull(),
                
                TextInput::make('organizer_name')
                    ->label('Penyelenggara')
                    ->default('HASTANA Indonesia'),
                
                TextInput::make('contact_email')
                    ->label('Email')
                    ->email(),
                
                TextInput::make('contact_phone')
                    ->label('Telepon')
                    ->tel(),
                
                TagsInput::make('tags')
                    ->label('Tags')
                    ->columnSpanFull(),
                
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'cancelled' => 'Cancelled',
                        'finished' => 'Finished',
                    ])
                    ->default('draft')
                    ->required(),
                
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
                
                Toggle::make('is_featured')
                    ->label('Featured')
                    ->default(false),
                
                Toggle::make('is_trending')
                    ->label('Trending')
                    ->default(false),
                
                TextInput::make('rating')
                    ->label('Rating')
                    ->numeric()
                    ->disabled(),
                
                TextInput::make('total_reviews')
                    ->label('Total Review')
                    ->numeric()
                    ->disabled(),
            ]);
    }
}
