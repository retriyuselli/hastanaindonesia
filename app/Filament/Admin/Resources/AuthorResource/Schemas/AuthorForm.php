<?php

namespace App\Filament\Admin\Resources\AuthorResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class AuthorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Author Information')
                    ->tabs([
                        Tabs\Tab::make('Basic Information')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Section::make('Personal Details')
                                    ->description('Enter the author\'s basic information')
                                    ->icon('heroicon-o-identification')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('name')
                                                    ->label('Full Name')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(function ($state, callable $set, $get) {
                                                        if (empty($get('slug'))) {
                                                            $set('slug', \Illuminate\Support\Str::slug($state));
                                                        }
                                                    })
                                                    ->helperText('Full name of the author')
                                                    ->prefixIcon('heroicon-o-user'),
                                                
                                                TextInput::make('slug')
                                                    ->label('URL Slug')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->unique(ignoreRecord: true)
                                                    ->helperText('URL-friendly slug (auto-generated from name)')
                                                    ->prefixIcon('heroicon-o-link')
                                                    ->suffix('.html'),
                                            ]),
                                        
                                        TextInput::make('email')
                                            ->label('Email Address')
                                            ->email()
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true)
                                            ->helperText('Primary email address for the author')
                                            ->prefixIcon('heroicon-o-envelope')
                                            ->suffixIcon('heroicon-o-at-symbol'),
                                        
                                        Textarea::make('bio')
                                            ->label('Biography')
                                            ->rows(4)
                                            ->maxLength(500)
                                            ->helperText('Short biography or description (max 500 characters)')
                                            ->columnSpanFull()
                                            ->placeholder('Write a brief biography about the author...'),
                                        
                                        Toggle::make('is_active')
                                            ->label('Active Status')
                                            ->default(true)
                                            ->helperText('Only active authors can be assigned to blogs and appear publicly')
                                            ->inline(false),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Profile & Media')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Section::make('Profile Picture')
                                    ->description('Upload and manage the author\'s profile picture')
                                    ->icon('heroicon-o-camera')
                                    ->schema([
                                        FileUpload::make('avatar')
                                            ->label('Avatar')
                                            ->image()
                                            ->directory('authors/avatars')
                                            ->disk('public')
                                            ->visibility('public')
                                            ->imageEditor()
                                            ->imageCropAspectRatio('1:1')
                                            ->imageResizeTargetWidth('400')
                                            ->imageResizeTargetHeight('400')
                                            ->imageResizeMode('cover')
                                            ->circleCropper()
                                            ->maxSize(2048)
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                            ->downloadable()
                                            ->openable()
                                            ->helperText('Upload profile picture (400x400px recommended, max 2MB). Square images work best.')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Social Media')
                            ->icon('heroicon-o-globe-alt')
                            ->schema([
                                Section::make('Website & Social Links')
                                    ->description('Add website and social media links for the author')
                                    ->icon('heroicon-o-link')
                                    ->schema([
                                        TextInput::make('website')
                                            ->label('Personal Website')
                                            ->url()
                                            ->maxLength(255)
                                            ->prefixIcon('heroicon-o-globe-alt')
                                            ->placeholder('https://example.com')
                                            ->helperText('Personal website or professional portfolio')
                                            ->columnSpanFull(),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('facebook')
                                                    ->label('Facebook')
                                                    ->url()
                                                    ->maxLength(255)
                                                    ->prefixIcon('heroicon-o-link')
                                                    ->placeholder('https://facebook.com/username')
                                                    ->helperText('Facebook profile URL'),
                                                
                                                TextInput::make('twitter')
                                                    ->label('Twitter / X')
                                                    ->url()
                                                    ->maxLength(255)
                                                    ->prefixIcon('heroicon-o-link')
                                                    ->placeholder('https://twitter.com/username')
                                                    ->helperText('Twitter/X profile URL'),
                                            ]),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('instagram')
                                                    ->label('Instagram')
                                                    ->url()
                                                    ->maxLength(255)
                                                    ->prefixIcon('heroicon-o-link')
                                                    ->placeholder('https://instagram.com/username')
                                                    ->helperText('Instagram profile URL'),
                                                
                                                TextInput::make('linkedin')
                                                    ->label('LinkedIn')
                                                    ->url()
                                                    ->maxLength(255)
                                                    ->prefixIcon('heroicon-o-link')
                                                    ->placeholder('https://linkedin.com/in/username')
                                                    ->helperText('LinkedIn profile URL'),
                                            ]),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }
}
