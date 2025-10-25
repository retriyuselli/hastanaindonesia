<?php

namespace App\Filament\Admin\Resources\BlogComments\Schemas;

use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class BlogCommentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Blog Article Info
                TextEntry::make('blog.title')
                    ->label('Blog Article')
                    ->weight(FontWeight::Bold)
                    ->color('primary')
                    ->url(fn ($record) => $record->blog ? route('blog.detail', $record->blog->slug) : null)
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-document-text')
                    ->columnSpanFull(),

                // Commenter Information
                TextEntry::make('name')
                    ->label('Commenter Name')
                    ->icon('heroicon-o-user')
                    ->copyable()
                    ->copyMessage('Name copied!')
                    ->weight(FontWeight::SemiBold),

                TextEntry::make('email')
                    ->label('Email Address')
                    ->icon('heroicon-o-envelope')
                    ->copyable()
                    ->copyMessage('Email copied!')
                    ->color('info'),

                // Comment Content
                TextEntry::make('comment')
                    ->label('Comment Text')
                    ->columnSpanFull()
                    ->prose()
                    ->markdown()
                    ->weight(FontWeight::Medium),

                // Approval Status
                IconEntry::make('is_approved')
                    ->label('Approval Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('warning'),

                TextEntry::make('status_display')
                    ->label('Status')
                    ->badge()
                    ->state(fn ($record) => $record->is_approved ? 'Approved' : 'Pending Review')
                    ->color(fn ($record) => $record->is_approved ? 'success' : 'warning'),

                // Parent Comment (if reply)
                TextEntry::make('parent.comment')
                    ->label('Reply To')
                    ->default('Top-level comment (not a reply)')
                    ->limit(100)
                    ->tooltip(fn ($record) => $record->parent ? $record->parent->comment : null)
                    ->columnSpanFull()
                    ->visible(fn ($record) => $record->parent_id !== null),

                // Avatar
                ImageEntry::make('avatar')
                    ->label('Avatar')
                    ->defaultImageUrl(fn ($record) => $record->avatar_url)
                    ->circular()
                    ->size(80)
                    ->visible(fn ($record) => $record->avatar !== null),

                // Metadata
                TextEntry::make('created_at')
                    ->label('Submitted At')
                    ->dateTime('M d, Y \a\t H:i:s')
                    ->since()
                    ->icon('heroicon-o-clock'),

                TextEntry::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M d, Y \a\t H:i:s')
                    ->since()
                    ->icon('heroicon-o-arrow-path')
                    ->visible(fn ($record) => $record->updated_at && $record->updated_at != $record->created_at),

                // Technical Info
                TextEntry::make('ip_address')
                    ->label('IP Address')
                    ->icon('heroicon-o-globe-alt')
                    ->copyable()
                    ->placeholder('Not recorded')
                    ->badge()
                    ->color('gray'),

                TextEntry::make('user_agent')
                    ->label('Browser / User Agent')
                    ->icon('heroicon-o-computer-desktop')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->user_agent)
                    ->placeholder('Not recorded')
                    ->columnSpanFull(),

                // Character Count
                TextEntry::make('comment_length')
                    ->label('Comment Length')
                    ->state(fn ($record) => strlen($record->comment) . ' characters')
                    ->badge()
                    ->color(fn ($record) => strlen($record->comment) > 500 ? 'warning' : 'success')
                    ->icon('heroicon-o-hashtag'),

                // Spam Detection
                TextEntry::make('spam_check')
                    ->label('Spam Check')
                    ->state(fn ($record) => $record->isPotentialSpam() ? '⚠️ Potential Spam Detected' : '✓ Looks Safe')
                    ->badge()
                    ->color(fn ($record) => $record->isPotentialSpam() ? 'danger' : 'success')
                    ->visible(fn ($record) => method_exists($record, 'isPotentialSpam')),
            ])
            ->columns(2);
    }
}
