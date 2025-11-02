<?php

namespace App\Filament\Admin\Resources\Blogs\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Schemas\Schema;
use App\Models\BlogCategory;
use App\Models\Author;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Blog Form')
                    ->tabs([
                        // Tab 1: Konten Utama
                        Tabs\Tab::make('Konten Utama')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Section::make('Informasi Dasar')
                                    ->description('Informasi utama artikel blog')
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Judul Artikel')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                                // Auto generate slug from title if slug is empty
                                                if (empty($get('slug'))) {
                                                    $set('slug', \Illuminate\Support\Str::slug($state));
                                                }
                                            })
                                            ->helperText('Judul artikel yang menarik dan SEO-friendly')
                                            ->columnSpanFull(),
                                        
                                        TextInput::make('slug')
                                            ->label('URL Slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true)
                                            ->helperText('URL-friendly slug (otomatis dibuat dari judul)')
                                            ->columnSpanFull(),
                                        
                                        Textarea::make('excerpt')
                                            ->label('Ringkasan')
                                            ->required()
                                            ->rows(3)
                                            ->maxLength(500)
                                            ->helperText('Ringkasan singkat artikel (max 500 karakter)')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),
                                
                                Section::make('Konten Artikel')
                                    ->description('Tulis konten artikel dengan formatting yang sesuai')
                                    ->schema([
                                        RichEditor::make('content')
                                            ->label('Konten')
                                            ->required()
                                            ->columnSpanFull()
                                            ->toolbarButtons([
                                                'attachFiles',
                                                'blockquote',
                                                'bold',
                                                'bulletList',
                                                'codeBlock',
                                                'h2',
                                                'h3',
                                                'italic',
                                                'link',
                                                'orderedList',
                                                'redo',
                                                'strike',
                                                'underline',
                                                'undo',
                                            ])
                                            ->fileAttachmentsDirectory('blog-attachments')
                                            ->helperText('Gunakan H2 untuk judul bagian utama, H3 untuk sub-bagian.')
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function ($state, callable $set) {
                                                // Auto calculate read time based on content
                                                $wordCount = str_word_count(strip_tags($state));
                                                $readTime = max(1, ceil($wordCount / 200)); // Average reading speed: 200 words/minute
                                                $set('read_time', $readTime);
                                            }),
                                    ]),
                            ]),
                        
                        // Tab 2: Media & Kategori
                        Tabs\Tab::make('Media & Kategori')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Section::make('Featured Image')
                                    ->description('Upload gambar utama untuk artikel')
                                    ->schema([
                                        FileUpload::make('featured_image')
                                            ->label('Gambar Unggulan')
                                            ->image()
                                            ->directory('blog-images')
                                            ->disk('public')
                                            ->visibility('public')
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([
                                                '16:9',  // Recommended for featured images
                                            ])
                                            ->imageCropAspectRatio('16:9')
                                            ->imageResizeTargetWidth('1200')
                                            ->imageResizeTargetHeight('630')
                                            ->imageResizeMode('cover')
                                            ->maxSize(2048)
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                            ->downloadable()
                                            ->openable()
                                            ->imagePreviewHeight('250')
                                            ->helperText('Upload featured image (max 2MB). Optimal: 1200x630px (16:9). Format: JPG, PNG, WebP.')
                                            ->columnSpanFull(),
                                    ]),
                                
                                Section::make('Kategorisasi')
                                    ->description('Kategori dan author artikel')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('blog_category_id')
                                                    ->label('Kategori')
                                                    ->required()
                                                    ->options(BlogCategory::all()->pluck('name', 'id'))
                                                    ->searchable()
                                                    ->preload()
                                                    ->helperText('Pilih kategori blog')
                                                    ->native(false),
                                                
                                                Select::make('author_id')
                                                    ->label('Penulis')
                                                    ->required()
                                                    ->relationship('author', 'name', function ($query) {
                                                        return $query->where('is_active', true);
                                                    })
                                                    ->searchable()
                                                    ->preload()
                                                    ->createOptionForm([
                                                        TextInput::make('name')
                                                            ->label('Nama Penulis')
                                                            ->required()
                                                            ->maxLength(255),
                                                        TextInput::make('email')
                                                            ->email()
                                                            ->required()
                                                            ->maxLength(255),
                                                        TextInput::make('slug')
                                                            ->maxLength(255),
                                                        Textarea::make('bio')
                                                            ->label('Biografi')
                                                            ->rows(3),
                                                    ])
                                                    ->helperText('Pilih author (hanya author aktif)')
                                                    ->native(false),
                                            ]),
                                        
                                        TagsInput::make('tags')
                                            ->label('Tags')
                                            ->placeholder('Tekan Enter setelah setiap tag')
                                            ->helperText('Tags artikel untuk SEO dan filtering')
                                            ->separator(',')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        
                        // Tab 3: SEO & Meta
                        Tabs\Tab::make('SEO & Meta')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Section::make('Search Engine Optimization')
                                    ->description('Optimasi artikel untuk mesin pencari')
                                    ->schema([
                                        TextInput::make('meta_title')
                                            ->label('Meta Title')
                                            ->maxLength(60)
                                            ->helperText('SEO Title (max 60 karakter, kosongkan untuk gunakan judul artikel)')
                                            ->columnSpanFull(),
                                        
                                        Textarea::make('meta_description')
                                            ->label('Meta Description')
                                            ->rows(3)
                                            ->maxLength(160)
                                            ->helperText('SEO Description (max 160 karakter, kosongkan untuk gunakan excerpt)')
                                            ->columnSpanFull(),
                                        
                                        TextInput::make('seo_keywords')
                                            ->label('SEO Keywords')
                                            ->maxLength(255)
                                            ->helperText('Keywords untuk SEO, pisahkan dengan koma')
                                            ->columnSpanFull(),
                                    ]),
                                
                                Section::make('Statistik & Info')
                                    ->description('Informasi dan statistik artikel')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                TextInput::make('read_time')
                                                    ->label('Waktu Baca')
                                                    ->required()
                                                    ->numeric()
                                                    ->default(5)
                                                    ->suffix('menit')
                                                    ->helperText('Estimasi waktu baca (otomatis)')
                                                    ->disabled()
                                                    ->dehydrated(),
                                                
                                                TextInput::make('views_count')
                                                    ->label('Total Views')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->disabled()
                                                    ->dehydrated()
                                                    ->helperText('Jumlah views'),
                                                
                                                TextInput::make('likes_count')
                                                    ->label('Total Likes')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->disabled()
                                                    ->dehydrated()
                                                    ->helperText('Jumlah likes'),
                                            ]),
                                    ]),
                            ]),
                        
                        // Tab 4: Pengaturan Publikasi
                        Tabs\Tab::make('Publikasi')
                            ->icon('heroicon-o-rocket-launch')
                            ->schema([
                                Section::make('Status Publikasi')
                                    ->description('Atur status dan jadwal publikasi artikel')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Toggle::make('is_published')
                                                    ->label('Publikasikan Artikel')
                                                    ->default(false)
                                                    ->helperText('Aktifkan untuk mempublikasikan artikel')
                                                    ->inline(false)
                                                    ->live(),
                                                
                                                Toggle::make('is_featured')
                                                    ->label('Artikel Unggulan')
                                                    ->default(false)
                                                    ->helperText('Tampilkan di artikel featured')
                                                    ->inline(false),
                                            ]),
                                        
                                        DateTimePicker::make('published_at')
                                            ->label('Tanggal & Waktu Publikasi')
                                            ->default(now())
                                            ->helperText('Tanggal dan waktu artikel dipublikasikan')
                                            ->native(false)
                                            ->displayFormat('d F Y, H:i')
                                            ->columnSpanFull(),
                                        
                                        Select::make('status')
                                            ->label('Status Artikel')
                                            ->options([
                                                'draft' => 'Draft',
                                                'published' => 'Published',
                                                'scheduled' => 'Scheduled',
                                                'archived' => 'Archived',
                                            ])
                                            ->default('draft')
                                            ->required()
                                            ->native(false)
                                            ->helperText('Status saat ini dari artikel'),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString()
                    ->activeTab(1),
            ]);
    }
}
