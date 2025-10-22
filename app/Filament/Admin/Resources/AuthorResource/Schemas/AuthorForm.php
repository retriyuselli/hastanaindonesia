<?php

namespace App\Filament\Admin\Resources\AuthorResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AuthorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        if (empty($get('slug'))) {
                            $set('slug', \Illuminate\Support\Str::slug($state));
                        }
                    })
                    ->helperText('Full name of the author'),
                
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('URL-friendly slug (auto-generated from name)'),
                
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Author email address'),
                
                FileUpload::make('avatar')
                    ->label('Avatar')
                    ->image()
                    ->directory('authors')
                    ->disk('public')
                    ->visibility('public')
                    ->imageEditor()
                    ->imageCropAspectRatio('1:1')
                    ->imageResizeTargetWidth('300')
                    ->imageResizeTargetHeight('300')
                    ->imageResizeMode('cover')
                    ->circleCropper()
                    ->maxSize(1024)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->downloadable()
                    ->openable()
                    ->helperText('Upload avatar (300x300px, max 1MB). Square crop recommended.'),
                
                Textarea::make('bio')
                    ->rows(4)
                    ->maxLength(500)
                    ->helperText('Short biography (max 500 characters)')
                    ->columnSpanFull(),
                
                TextInput::make('website')
                    ->url()
                    ->maxLength(255)
                    ->prefixIcon('heroicon-o-globe-alt')
                    ->placeholder('https://example.com')
                    ->helperText('Personal website or blog'),
                
                TextInput::make('facebook')
                    ->url()
                    ->maxLength(255)
                    ->prefixIcon('heroicon-o-link')
                    ->placeholder('https://facebook.com/username')
                    ->helperText('Facebook profile URL'),
                
                TextInput::make('twitter')
                    ->url()
                    ->maxLength(255)
                    ->prefixIcon('heroicon-o-link')
                    ->placeholder('https://twitter.com/username')
                    ->helperText('Twitter/X profile URL'),
                
                TextInput::make('instagram')
                    ->url()
                    ->maxLength(255)
                    ->prefixIcon('heroicon-o-link')
                    ->placeholder('https://instagram.com/username')
                    ->helperText('Instagram profile URL'),
                
                TextInput::make('linkedin')
                    ->url()
                    ->maxLength(255)
                    ->prefixIcon('heroicon-o-link')
                    ->placeholder('https://linkedin.com/in/username')
                    ->helperText('LinkedIn profile URL'),
                
                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->helperText('Only active authors can be assigned to blogs'),
            ]);
    }
}
