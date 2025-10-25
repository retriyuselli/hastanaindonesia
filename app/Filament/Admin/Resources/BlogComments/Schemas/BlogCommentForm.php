<?php

namespace App\Filament\Admin\Resources\BlogComments\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BlogCommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Blog Selection
                Select::make('blog_id')
                    ->label('Blog Article')
                    ->relationship('blog', 'title')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpanFull()
                    ->helperText('Select the blog article this comment belongs to')
                    ->prefixIcon('heroicon-o-document-text'),

                // Commenter Info
                TextInput::make('name')
                    ->label('Commenter Name')
                    ->required()
                    ->maxLength(255)
                    ->prefixIcon('heroicon-o-user')
                    ->placeholder('John Doe'),

                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->prefixIcon('heroicon-o-envelope')
                    ->placeholder('john@example.com'),

                // Comment Content
                Textarea::make('comment')
                    ->label('Comment Text')
                    ->required()
                    ->rows(5)
                    ->maxLength(1000)
                    ->columnSpanFull()
                    ->helperText('Maximum 1000 characters')
                    ->placeholder('Write comment here...'),

                // Approval Status
                Toggle::make('is_approved')
                    ->label('Approved')
                    ->helperText('Approve this comment to show it publicly')
                    ->default(false)
                    ->inline(false)
                    ->onColor('success')
                    ->offColor('warning'),

                // Parent Comment (for replies)
                Select::make('parent_id')
                    ->label('Reply To Comment')
                    ->relationship('parent', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => \Illuminate\Support\Str::limit($record->comment, 50))
                    ->searchable()
                    ->preload()
                    ->placeholder('Leave empty for top-level comment')
                    ->helperText('Select parent comment if this is a reply'),

                // Avatar URL
                TextInput::make('avatar')
                    ->label('Avatar URL')
                    ->url()
                    ->maxLength(500)
                    ->placeholder('https://example.com/avatar.jpg')
                    ->helperText('Optional: Custom avatar URL')
                    ->columnSpanFull(),

                // Metadata (Read-only)
                Placeholder::make('created_info')
                    ->label('Submission Info')
                    ->content(fn ($record) => $record 
                        ? "Submitted on " . $record->created_at->format('M d, Y \a\t H:i:s')
                        : 'Not submitted yet')
                    ->columnSpanFull(),

                TextInput::make('ip_address')
                    ->label('IP Address')
                    ->placeholder('192.168.1.1')
                    ->maxLength(45)
                    ->disabled()
                    ->dehydrated(false)
                    ->helperText('Automatically captured on submission')
                    ->prefixIcon('heroicon-o-globe-alt'),

                TextInput::make('user_agent')
                    ->label('User Agent / Browser')
                    ->placeholder('Browser information')
                    ->maxLength(500)
                    ->disabled()
                    ->dehydrated(false)
                    ->helperText('Automatically captured on submission')
                    ->columnSpanFull()
                    ->prefixIcon('heroicon-o-computer-desktop'),
            ])
            ->columns(2);
    }
}
