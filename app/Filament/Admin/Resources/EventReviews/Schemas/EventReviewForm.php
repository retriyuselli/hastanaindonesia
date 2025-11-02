<?php

namespace App\Filament\Admin\Resources\EventReviews\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class EventReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Review Information')
                    ->tabs([
                        Tabs\Tab::make('Review Content')
                            ->icon('heroicon-o-chat-bubble-left-right')
                            ->schema([
                                Section::make('Event & User Information')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('event_hastana_id')
                                                    ->label('Event')
                                                    ->relationship('event', 'title')
                                                    ->required()
                                                    ->searchable()
                                                    ->preload()
                                                    ->native(false)
                                                    ->helperText('Pilih event yang direview'),
                                                
                                                Select::make('user_id')
                                                    ->label('User/Reviewer')
                                                    ->relationship('user', 'name')
                                                    ->required()
                                                    ->searchable()
                                                    ->preload()
                                                    ->native(false),
                                                
                                                Select::make('event_participant_id')
                                                    ->label('Participant (if verified)')
                                                    ->relationship('participant', 'id')
                                                    ->searchable()
                                                    ->preload()
                                                    ->native(false)
                                                    ->helperText('Link to event participant if this is a verified review'),
                                            ]),
                                    ]),
                                
                                Section::make('Rating & Review')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('rating')
                                                    ->label('Rating')
                                                    ->options([
                                                        1 => '⭐ 1 - Sangat Buruk',
                                                        2 => '⭐⭐ 2 - Buruk',
                                                        3 => '⭐⭐⭐ 3 - Cukup',
                                                        4 => '⭐⭐⭐⭐ 4 - Baik',
                                                        5 => '⭐⭐⭐⭐⭐ 5 - Sangat Baik',
                                                    ])
                                                    ->required()
                                                    ->native(false),
                                                
                                                Toggle::make('would_recommend')
                                                    ->label('Would Recommend?')
                                                    ->inline(false)
                                                    ->default(true),
                                            ]),
                                        
                                        TextInput::make('title')
                                            ->label('Review Title')
                                            ->maxLength(255)
                                            ->required()
                                            ->placeholder('Singkat & Jelas'),
                                        
                                        RichEditor::make('review')
                                            ->label('Review Detail')
                                            ->required()
                                            ->columnSpanFull()
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'bulletList',
                                                'orderedList',
                                                'undo',
                                                'redo',
                                            ]),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                Textarea::make('pros')
                                                    ->label('Pros (Kelebihan)')
                                                    ->rows(4)
                                                    ->placeholder('Apa yang bagus dari event ini?'),
                                                
                                                Textarea::make('cons')
                                                    ->label('Cons (Kekurangan)')
                                                    ->rows(4)
                                                    ->placeholder('Apa yang perlu ditingkatkan?'),
                                            ]),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Moderation')
                            ->icon('heroicon-o-shield-check')
                            ->schema([
                                Section::make('Review Status')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Toggle::make('is_verified_participant')
                                                    ->label('Verified Participant')
                                                    ->inline(false)
                                                    ->helperText('Apakah reviewer adalah peserta event?'),
                                                
                                                Toggle::make('is_approved')
                                                    ->label('Approved')
                                                    ->inline(false)
                                                    ->default(false)
                                                    ->helperText('Tampilkan review di public?'),
                                                
                                                Toggle::make('is_featured')
                                                    ->label('Featured Review')
                                                    ->inline(false)
                                                    ->helperText('Tandai sebagai review unggulan'),
                                            ]),
                                    ]),
                                
                                Section::make('Engagement Metrics')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('helpful_count')
                                                    ->label('Helpful Count')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->disabled(),
                                                
                                                TextInput::make('reported_count')
                                                    ->label('Reported Count')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->disabled(),
                                            ]),
                                    ]),
                                
                                Section::make('Moderator Area')
                                    ->schema([
                                        Textarea::make('moderator_notes')
                                            ->label('Moderator Notes')
                                            ->rows(3)
                                            ->placeholder('Internal notes untuk moderasi...')
                                            ->columnSpanFull(),
                                        
                                        TextInput::make('ip_address')
                                            ->label('IP Address')
                                            ->disabled()
                                            ->placeholder('Auto-captured'),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
