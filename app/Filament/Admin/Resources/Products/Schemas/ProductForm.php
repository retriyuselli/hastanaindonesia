<?php

namespace App\Filament\Admin\Resources\Products\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Schemas\Schema;
use App\Models\WeddingOrganizer;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Informasi Dasar')
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        Select::make('wedding_organizer_id')
                            ->label('Wedding Organizer')
                            ->relationship('weddingOrganizer', 'organizer_name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan(2),
                        
                        TextInput::make('name')
                            ->label('Nama Produk')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, callable $set) => 
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                            ),
                        
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('URL friendly name, auto-generate dari nama produk'),
                        
                        RichEditor::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                    ]),
                
                Section::make('Harga')
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('original_price')
                            ->label('Harga Asli')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($get, callable $set) {
                                $original = $get('original_price');
                                $price = $get('price');
                                if ($original && $price) {
                                    $set('discount', $original - $price);
                                }
                            }),
                        
                        TextInput::make('price')
                            ->label('Harga Jual')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($get, callable $set) {
                                $original = $get('original_price');
                                $price = $get('price');
                                if ($original && $price) {
                                    $set('discount', $original - $price);
                                }
                            }),
                        
                        TextInput::make('discount')
                            ->label('Diskon')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled()
                            ->dehydrated()
                            ->helperText('Auto-calculated dari harga asli - harga jual')
                            ->columnSpan(2),
                    ]),
                
                Section::make('Media & Features')
                    ->columns(1)
                    ->columnSpan(2)
                    ->schema([
                        FileUpload::make('images')
                            ->label('Gambar Produk')
                            ->multiple()
                            ->image()
                            ->maxSize(2048)
                            ->disk('public')
                            ->directory('products')
                            ->reorderable()
                            ->helperText('Upload multiple gambar, gambar pertama akan menjadi thumbnail'),
                        
                        Repeater::make('features')
                            ->label('Fitur/Benefit')
                            ->simple(
                                TextInput::make('feature')
                                    ->label('Fitur')
                                    ->required()
                            )
                            ->defaultItems(0)
                            ->addActionLabel('Tambah Fitur')
                            ->collapsible()
                            ->helperText('Daftar fitur yang didapat customer'),
                        
                        TagsInput::make('badges')
                            ->label('Badges')
                            ->placeholder('Ketik dan tekan Enter')
                            ->suggestions(['FREE PREWED', 'BEST DEAL', 'LIMITED', 'BEST VALUE', 'TRENDING'])
                            ->helperText('Label/badge untuk produk (misal: FREE PREWED, BEST DEAL)'),
                    ]),
                
                Section::make('Pengaturan')
                    ->columnSpan(1)
                    ->schema([
                        Toggle::make('limited_offer')
                            ->label('Penawaran Terbatas')
                            ->default(false)
                            ->helperText('Tampilkan badge "Harga Terbatas"'),
                        
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Hanya produk aktif yang tampil di website'),
                        
                        TextInput::make('sort_order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0)
                            ->helperText('Urutan tampilan (kecil ke besar)'),
                    ]),
            ]);
    }
}
