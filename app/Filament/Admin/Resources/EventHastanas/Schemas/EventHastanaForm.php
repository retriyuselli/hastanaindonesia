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
use App\Enums\ProvinsiEnum;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class EventHastanaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Event Information')
                    ->tabs([
                        Tabs\Tab::make('Basic Information')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Section::make('Event Details')
                                    ->description('Basic information about the event')
                                    ->icon('heroicon-o-information-circle')
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Event Title')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function ($get, $set, ?string $state) {
                                                if (!$get('slug') || $get('slug') === Str::slug($get('title'))) {
                                                    $set('slug', Str::slug($state));
                                                }
                                            })
                                            ->placeholder('e.g., Wedding Photography Masterclass')
                                            ->helperText('Attractive title for your event')
                                            ->prefixIcon('heroicon-o-sparkles')
                                            ->columnSpanFull(),
                                        
                                        TextInput::make('slug')
                                            ->label('URL Slug')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255)
                                            ->placeholder('wedding-photography-masterclass')
                                            ->helperText('URL-friendly slug (auto-generated from title)')
                                            ->prefixIcon('heroicon-o-link')
                                            ->suffix('.html')
                                            ->columnSpanFull(),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('event_category_id')
                                                    ->label('Event Category')
                                                    ->relationship('eventCategory', 'name')
                                                    ->searchable()
                                                    ->preload()
                                                    ->required()
                                                    ->placeholder('Select category')
                                                    ->prefixIcon('heroicon-o-folder'),
                                                
                                                Select::make('event_type')
                                                    ->label('Event Type')
                                                    ->options([
                                                        'internal' => 'Internal Event',
                                                        'eksternal' => 'External Event',
                                                    ])
                                                    ->required()
                                                    ->default('internal')
                                                    ->native(false)
                                                    ->prefixIcon('heroicon-o-building-office'),
                                            ]),
                                    ]),
                                
                                Section::make('Event Content')
                                    ->description('Detailed description and content of the event')
                                    ->icon('heroicon-o-document')
                                    ->schema([
                                        Textarea::make('short_description')
                                            ->label('Short Description')
                                            ->rows(3)
                                            ->maxLength(300)
                                            ->helperText('Brief summary of the event (max 300 characters)')
                                            ->placeholder('A compelling short description of your event...')
                                            ->columnSpanFull(),
                                        
                                        RichEditor::make('description')
                                            ->label('Full Description')
                                            ->required()
                                            ->placeholder('Write the full details of your event here...')
                                            ->helperText('Detailed description with formatting')
                                            ->columnSpanFull(),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                RichEditor::make('benefits')
                                                    ->label('Event Benefits')
                                                    ->placeholder('• Professional certificate\n• Networking opportunities\n• Practical skills')
                                                    ->helperText('What participants will gain')
                                                    ->columnSpanFull(),
                                                
                                                RichEditor::make('requirements')
                                                    ->label('Requirements')
                                                    ->placeholder('• Basic photography knowledge\n• Bring camera equipment\n• Laptop for editing')
                                                    ->helperText('What participants need to bring/know')
                                                    ->columnSpanFull(),
                                            ]),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Schedule & Location')
                            ->icon('heroicon-o-calendar-days')
                            ->schema([
                                Section::make('Event Schedule')
                                    ->description('Date and time information')
                                    ->icon('heroicon-o-clock')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                DatePicker::make('start_date')
                                                    ->label('Start Date')
                                                    ->required()
                                                    ->native(false)
                                                    ->displayFormat('d M Y')
                                                    ->prefixIcon('heroicon-o-calendar'),
                                                
                                                DatePicker::make('end_date')
                                                    ->label('End Date')
                                                    ->required()
                                                    ->native(false)
                                                    ->displayFormat('d M Y')
                                                    ->prefixIcon('heroicon-o-calendar')
                                                    ->afterOrEqual('start_date'),
                                            ]),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                TimePicker::make('start_time')
                                                    ->label('Start Time')
                                                    ->seconds(false)
                                                    ->displayFormat('H:i')
                                                    ->prefixIcon('heroicon-o-clock'),
                                                
                                                TimePicker::make('end_time')
                                                    ->label('End Time')
                                                    ->seconds(false)
                                                    ->displayFormat('H:i')
                                                    ->prefixIcon('heroicon-o-clock'),
                                            ]),
                                    ]),
                                
                                Section::make('Location Details')
                                    ->description('Event location and venue information')
                                    ->icon('heroicon-o-map-pin')
                                    ->schema([
                                        Select::make('location_type')
                                            ->label('Location Type')
                                            ->options([
                                                'offline' => '🏢 Offline (Physical Location)',
                                                'online' => '💻 Online (Virtual)',
                                                'hybrid' => '🔄 Hybrid (Both)',
                                            ])
                                            ->required()
                                            ->default('offline')
                                            ->native(false)
                                            ->live()
                                            ->helperText('Choose the type of event location')
                                            ->columnSpanFull(),
                                        
                                        TextInput::make('online_link')
                                            ->label('Online Meeting Link')
                                            ->url()
                                            ->placeholder('https://zoom.us/j/123456789 or https://meet.google.com/xxx-xxxx-xxx')
                                            ->helperText('Leave empty initially, fill on event day for security')
                                            ->prefixIcon('heroicon-o-link')
                                            ->columnSpanFull()
                                            ->visible(fn ($get) => in_array($get('location_type'), ['online', 'hybrid'])),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('venue')
                                                    ->label('Venue Name')
                                                    ->placeholder('Main Hall, Convention Center, etc.')
                                                    ->prefixIcon('heroicon-o-building-office-2')
                                                    ->hidden(fn ($get) => $get('location_type') === 'online'),
                                                
                                                TextInput::make('location')
                                                    ->label('Full Address')
                                                    ->placeholder('Jl. Example No. 123, Building ABC')
                                                    ->helperText('Complete address of the event location')
                                                    ->prefixIcon('heroicon-o-map-pin')
                                                    ->required(fn ($get) => in_array($get('location_type'), ['offline', 'hybrid']))
                                                    ->hidden(fn ($get) => $get('location_type') === 'online'),
                                            ]),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('province')
                                                    ->label('Province')
                                                    ->options(ProvinsiEnum::toArray())
                                                    ->searchable()
                                                    ->preload()
                                                    ->live()
                                                    ->afterStateUpdated(fn (callable $set) => $set('city', null))
                                                    ->required(fn ($get) => in_array($get('location_type'), ['offline', 'hybrid']))
                                                    ->hidden(fn ($get) => $get('location_type') === 'online')
                                                    ->placeholder('Select province')
                                                    ->prefixIcon('heroicon-o-map'),
                                                
                                                Select::make('city')
                                                    ->label('City/Regency')
                                                    ->options(function (callable $get) {
                                                        $province = $get('province');
                                                        if (!$province) {
                                                            return [];
                                                        }
                                                        $cities = ProvinsiEnum::getKotaKabupaten($province);
                                                        return array_combine($cities, $cities);
                                                    })
                                                    ->searchable()
                                                    ->preload()
                                                    ->required(fn ($get) => in_array($get('location_type'), ['offline', 'hybrid']))
                                                    ->hidden(fn ($get) => $get('location_type') === 'online')
                                                    ->disabled(fn (callable $get) => !$get('province'))
                                                    ->placeholder('Select city/regency')
                                                    ->helperText('Select province first')
                                                    ->prefixIcon('heroicon-o-building-office'),
                                            ]),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Pricing & Capacity')
                            ->icon('heroicon-o-banknotes')
                            ->schema([
                                Section::make('Event Pricing')
                                    ->description('Pricing and payment information')
                                    ->icon('heroicon-o-currency-dollar')
                                    ->schema([
                                        Toggle::make('is_free')
                                            ->label('Free Event')
                                            ->default(false)
                                            ->live()
                                            ->helperText('Toggle if this event is free of charge')
                                            ->columnSpanFull(),
                                        
                                        TextInput::make('price')
                                            ->label('Event Price')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->placeholder('250000')
                                            ->hidden(fn ($get) => $get('is_free') === true)
                                            ->required(fn ($get) => $get('is_free') === false)
                                            ->prefixIcon('heroicon-o-banknotes')
                                            ->helperText('Price per participant')
                                            ->columnSpanFull(),
                                    ]),
                                
                                Section::make('Participant Management')
                                    ->description('Capacity and registration management')
                                    ->icon('heroicon-o-users')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('max_participants')
                                                    ->label('Maximum Participants')
                                                    ->numeric()
                                                    ->minValue(1)
                                                    ->placeholder('100')
                                                    ->helperText('Maximum number of participants allowed')
                                                    ->prefixIcon('heroicon-o-user-group'),
                                                
                                                TextInput::make('current_participants')
                                                    ->label('Current Registrations')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->disabled()
                                                    ->helperText('Auto-updated from registrations')
                                                    ->prefixIcon('heroicon-o-users'),
                                            ]),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Media & Organizer')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Section::make('Event Media')
                                    ->description('Upload event image and media')
                                    ->icon('heroicon-o-camera')
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label('Event Banner/Image')
                                            ->image()
                                            ->disk('public')
                                            ->directory('events')
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([
                                                '16:9',
                                                '4:3',
                                                '1:1',
                                            ])
                                            ->imageCropAspectRatio('16:9')
                                            ->imageResizeTargetWidth('1200')
                                            ->imageResizeTargetHeight('675')
                                            ->maxSize(2048)
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                            ->helperText('Upload event banner (1200x675px recommended, max 2MB)')
                                            ->columnSpanFull(),
                                    ]),
                                
                                Section::make('Organizer Information')
                                    ->description('Contact details and organizer information')
                                    ->icon('heroicon-o-identification')
                                    ->schema([
                                        TextInput::make('organizer_name')
                                            ->label('Organizer Name')
                                            ->default('HASTANA INDONESIA')
                                            ->required()
                                            ->prefixIcon('heroicon-o-building-office')
                                            ->columnSpanFull(),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('contact_email')
                                                    ->label('Contact Email')
                                                    ->email()
                                                    ->prefixIcon('heroicon-o-envelope')
                                                    ->placeholder('event@hastanaindonesia.com'),
                                                
                                                TextInput::make('contact_phone')
                                                    ->label('Contact Phone')
                                                    ->tel()
                                                    ->prefixIcon('heroicon-o-phone')
                                                    ->placeholder('+62 812-3456-7890'),
                                            ]),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Settings & Status')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Section::make('Event Tags & Categories')
                                    ->description('Tags and categorization for better discovery')
                                    ->icon('heroicon-o-tag')
                                    ->schema([
                                        TagsInput::make('tags')
                                            ->label('Event Tags')
                                            ->placeholder('Add tags...')
                                            ->helperText('Add relevant tags for better searchability')
                                            ->columnSpanFull(),
                                    ]),
                                
                                Section::make('Publication Settings')
                                    ->description('Control event visibility and status')
                                    ->icon('heroicon-o-eye')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('status')
                                                    ->label('Event Status')
                                                    ->options([
                                                        'draft' => '📝 Draft',
                                                        'published' => '✅ Published',
                                                        'cancelled' => '❌ Cancelled',
                                                        'finished' => '🏁 Finished',
                                                    ])
                                                    ->default('draft')
                                                    ->required()
                                                    ->native(false),
                                                
                                                Toggle::make('is_active')
                                                    ->label('Active')
                                                    ->default(true)
                                                    ->helperText('Only active events are visible to public'),
                                            ]),
                                        
                                        Grid::make(3)
                                            ->schema([
                                                Toggle::make('is_featured')
                                                    ->label('Featured Event')
                                                    ->default(false)
                                                    ->helperText('Show in featured section'),
                                                
                                                Toggle::make('is_trending')
                                                    ->label('Trending')
                                                    ->default(false)
                                                    ->helperText('Mark as trending event'),
                                                
                                                // Spacer for alignment
                                                \Filament\Forms\Components\Placeholder::make('spacer')
                                                    ->hiddenLabel()
                                                    ->content(''),
                                            ]),
                                    ]),
                                
                                Section::make('Analytics & Reviews')
                                    ->description('Event performance metrics (read-only)')
                                    ->icon('heroicon-o-chart-bar')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('rating')
                                                    ->label('Average Rating')
                                                    ->numeric()
                                                    ->disabled()
                                                    ->suffixIcon('heroicon-o-star')
                                                    ->helperText('Auto-calculated from reviews'),
                                                
                                                TextInput::make('total_reviews')
                                                    ->label('Total Reviews')
                                                    ->numeric()
                                                    ->disabled()
                                                    ->suffixIcon('heroicon-o-chat-bubble-left-right')
                                                    ->helperText('Total number of reviews'),
                                            ]),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }
}
