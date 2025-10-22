<?php

namespace App\Filament\Admin\Resources\Blogs\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BlogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                // Featured Image
                ImageEntry::make('featured_image')
                    ->label('Featured Image')
                    ->disk('public')
                    ->defaultImageUrl(url('/images/placeholder.jpg'))
                    ->columnSpan(1),
                
                // Title
                TextEntry::make('title')
                    ->label('Title')
                    ->weight('bold')
                    ->size('lg')
                    ->columnSpan(2),
                
                // Slug
                TextEntry::make('slug')
                    ->label('Slug')
                    ->icon('heroicon-o-link')
                    ->copyable()
                    ->copyMessage('Slug copied!')
                    ->copyMessageDuration(1500)
                    ->columnSpan(2),
                
                // Category - Display name instead of ID
                TextEntry::make('blogCategory.name')
                    ->label('Category')
                    ->badge()
                    ->color('success')
                    ->columnSpan(1),
                
                // Author Name (via relationship)
                TextEntry::make('author.name')
                    ->label('Author')
                    ->icon('heroicon-o-user')
                    ->badge()
                    ->color('info')
                    ->placeholder('No author assigned')
                    ->columnSpan(1),
                
                // Meta Title
                TextEntry::make('meta_title')
                    ->label('Meta Title')
                    ->placeholder('No meta title set')
                    ->columnSpan(2),
                
                // Meta Description
                TextEntry::make('meta_description')
                    ->label('Meta Description')
                    ->placeholder('No meta description set')
                    ->columnSpanFull(),
                
                // Read Time
                TextEntry::make('read_time')
                    ->label('Read Time')
                    ->suffix(' minutes')
                    ->icon('heroicon-o-clock')
                    ->columnSpan(1),
                
                // Views Count
                TextEntry::make('views_count')
                    ->label('Total Views')
                    ->numeric()
                    ->icon('heroicon-o-eye')
                    ->columnSpan(1),
                
                // Likes Count
                TextEntry::make('likes_count')
                    ->label('Total Likes')
                    ->numeric()
                    ->icon('heroicon-o-heart')
                    ->default(0)
                    ->columnSpan(1),
                
                // Comments Count
                TextEntry::make('comments_count')
                    ->label('Total Comments')
                    ->numeric()
                    ->icon('heroicon-o-chat-bubble-left')
                    ->default(0)
                    ->columnSpan(1),
                
                // Is Published
                IconEntry::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->columnSpan(1),
                
                // Is Featured
                IconEntry::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->columnSpan(1),
                
                // Published At
                TextEntry::make('published_at')
                    ->label('Published Date')
                    ->dateTime('d M Y, H:i')
                    ->icon('heroicon-o-calendar')
                    ->placeholder('Not published yet')
                    ->columnSpan(1),
                
                // Created At
                TextEntry::make('created_at')
                    ->label('Created At')
                    ->dateTime('d M Y, H:i')
                    ->icon('heroicon-o-plus-circle')
                    ->columnSpan(1),
                
                // Updated At
                TextEntry::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('d M Y, H:i')
                    ->since()
                    ->icon('heroicon-o-arrow-path')
                    ->columnSpan(2),
            ]);
    }
}
