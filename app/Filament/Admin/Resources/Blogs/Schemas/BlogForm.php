<?php

namespace App\Filament\Admin\Resources\Blogs\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use App\Models\BlogCategory;
use App\Models\Author;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        // Auto generate slug from title if slug is empty
                        if (empty($get('slug'))) {
                            $set('slug', \Illuminate\Support\Str::slug($state));
                        }
                    })
                    ->helperText('Judul artikel yang menarik dan SEO-friendly'),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('URL-friendly slug (otomatis dibuat dari judul)'),
                Textarea::make('excerpt')
                    ->required()
                    ->rows(3)
                    ->maxLength(500)
                    ->helperText('Ringkasan singkat artikel (max 500 karakter)')
                    ->columnSpanFull(),
                RichEditor::make('content')
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
                    ->helperText('Tulis konten artikel dengan formatting yang sesuai. Gunakan H2 untuk judul bagian utama, H3 untuk sub-bagian.')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Auto calculate read time based on content
                        $wordCount = str_word_count(strip_tags($state));
                        $readTime = max(1, ceil($wordCount / 200)); // Average reading speed: 200 words/minute
                        $set('read_time', $readTime);
                    }),
                FileUpload::make('featured_image')
                    ->label('Featured Image')
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
                    ->helperText('Upload featured image (max 2MB). Optimal: 1200x630px (16:9 ratio). Format: JPG, PNG, WebP. Gambar akan otomatis dioptimasi.'),
                Select::make('blog_category_id')
                    ->required()
                    ->label('Category')
                    ->options(BlogCategory::all()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->helperText('Pilih kategori blog'),
                Select::make('author_id')
                    ->required()
                    ->label('Author')
                    ->relationship('author', 'name', function ($query) {
                        return $query->where('is_active', true);
                    })
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->maxLength(255),
                        Textarea::make('bio')
                            ->rows(3),
                    ])
                    ->helperText('Pilih author (hanya author yang aktif). Atau buat author baru.'),
                TextInput::make('meta_title')
                    ->maxLength(60)
                    ->helperText('SEO Title (max 60 karakter, kosongkan untuk gunakan judul artikel)'),
                Textarea::make('meta_description')
                    ->rows(2)
                    ->maxLength(160)
                    ->helperText('SEO Description (max 160 karakter, kosongkan untuk gunakan excerpt)')
                    ->columnSpanFull(),
                TextInput::make('tags')
                    ->maxLength(255)
                    ->helperText('Tags artikel, pisahkan dengan koma (contoh: wedding, tips, budget)'),
                TextInput::make('read_time')
                    ->required()
                    ->numeric()
                    ->default(5)
                    ->suffix('menit')
                    ->helperText('Estimasi waktu baca (otomatis dihitung dari konten)')
                    ->disabled()
                    ->dehydrated(),
                TextInput::make('views_count')
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->dehydrated()
                    ->helperText('Jumlah views (otomatis terupdate)'),
                Toggle::make('is_published')
                    ->label('Publish')
                    ->default(false)
                    ->helperText('Publikasikan artikel sekarang'),
                Toggle::make('is_featured')
                    ->label('Featured')
                    ->default(false)
                    ->helperText('Tampilkan di artikel featured'),
                DateTimePicker::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->default(now())
                    ->helperText('Tanggal dan waktu artikel dipublikasikan'),
            ]);
    }
}
