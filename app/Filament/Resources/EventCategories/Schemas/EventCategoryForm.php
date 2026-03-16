<?php

namespace App\Filament\Resources\EventCategories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class EventCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                // Basic Information
                TextInput::make('name')
                    ->label('🏷️ Nama Kategori')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Workshop, Seminar, Wedding Expo, dll.')
                    ->helperText('Nama kategori event yang akan ditampilkan')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($set, ?string $state) {
                        $set('slug', Str::slug((string) $state));
                    }),

                TextInput::make('slug')
                    ->label('🔗 Slug URL')
                    ->required()
                    ->maxLength(255)
                    ->readOnly()
                    ->placeholder('workshop-marketing-digital')
                    ->helperText('URL-friendly version dari nama kategori')
                    ->unique(ignoreRecord: true)
                    ->suffixIcon('heroicon-m-link')
                    ->rules(['alpha_dash'])
                    ->validationMessages([
                        'alpha_dash' => 'Slug hanya boleh mengandung huruf, angka, dash (-) dan underscore (_)',
                    ]),

                Textarea::make('description')
                    ->label('📝 Deskripsi')
                    ->placeholder('Deskripsi kategori event untuk memberikan informasi lebih detail...')
                    ->helperText('Deskripsi kategori yang akan ditampilkan di frontend')
                    ->rows(3)
                    ->columnSpan(2),

                // Visual Settings
                Select::make('icon')
                    ->label('🎯 Icon Kategori')
                    ->options([
                        'graduation-cap' => '🎓 Workshop/Training',
                        'chalkboard-teacher' => '🧑‍🏫 Pelatihan',
                        'chart-line' => '📊 Seminar/Talkshow',
                        'store' => '🏪 Wedding Expo',
                        'users' => '👥 Networking',
                        'trophy' => '🏆 Sertifikasi',
                        'star' => '⭐ Award/Kompetisi',
                        'heart' => '💖 Charity/CSR',
                        'camera' => '📷 Vendor Showcase',
                        'briefcase' => '💼 Business Development',
                        'lightbulb' => '💡 Technology & Innovation',
                        'calendar-alt' => '📅 Regional Meetup',
                        'rocket' => '🚀 Special Launch',
                    ])
                    ->searchable()
                    ->placeholder('Pilih icon yang sesuai')
                    ->helperText('Icon yang akan ditampilkan di card kategori')
                    ->suffixIcon('heroicon-m-face-smile'),

                Select::make('color')
                    ->label('🌈 Warna Kategori')
                    ->required()
                    ->default('#f59e0b')
                    ->helperText('Pilih warna theme untuk kategori ini')
                    ->options([
                        // Wedding Colors
                        '#FF69B4' => '💖 Pink (Wedding)',
                        '#FFB6C1' => '🌸 Light Pink',
                        '#FF1493' => '💗 Deep Pink',
                        '#DC143C' => '❤️ Crimson',

                        // Professional Colors
                        '#4F46E5' => '💼 Indigo (Professional)',
                        '#059669' => '✅ Emerald (Success)',
                        '#DC2626' => '🚨 Red (Important)',
                        '#D97706' => '⚠️ Amber (Warning)',
                        '#7C3AED' => '👑 Violet (Premium)',

                        // Event Colors
                        '#0EA5E9' => '🎓 Sky Blue (Workshop)',
                        '#10B981' => '📊 Green (Seminar)',
                        '#F59E0B' => '🎪 Yellow (Expo)',
                        '#8B5CF6' => '✨ Purple (Special)',
                        '#EC4899' => '🤝 Pink (Networking)',

                        // Additional Colors
                        '#6B7280' => '⚫ Gray (Neutral)',
                        '#EF4444' => '🔴 Red (Alert)',
                        '#F97316' => '🟠 Orange (Energy)',
                        '#22C55E' => '🟢 Green (Nature)',
                        '#3B82F6' => '🔵 Blue (Trust)',
                        '#A855F7' => '🟣 Purple (Creative)',
                        '#14B8A6' => '🟦 Teal (Fresh)',
                        '#F59E0B' => '🟡 Amber (Default)',
                    ])
                    ->searchable()
                    ->allowHtml(),

                // Settings
                Toggle::make('is_active')
                    ->label('✅ Status Aktif')
                    ->required()
                    ->default(true)
                    ->helperText('Kategori aktif akan ditampilkan di frontend')
                    ->onIcon('heroicon-m-check-circle')
                    ->offIcon('heroicon-m-x-circle')
                    ->onColor('success')
                    ->offColor('danger'),

                TextInput::make('sort_order')
                    ->label('🔢 Urutan Tampilan')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->maxValue(999)
                    ->placeholder('0')
                    ->helperText('Semakin kecil angka, semakin atas posisinya')
                    ->suffixIcon('heroicon-m-bars-3-bottom-left')
                    ->step(1),
            ]);
    }
}
