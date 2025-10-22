<?php

namespace App\Filament\Admin\Resources\EventHastanas\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EventHastanaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                ImageEntry::make('image')
                    ->label('Gambar Event')
                    ->disk('public')
                    ->height(250)
                    ->defaultImageUrl(url('/images/placeholder-event.jpg'))
                    ->columnSpan(1),
                
                TextEntry::make('title')
                    ->label('Judul Event')
                    ->weight('bold')
                    ->size('xl')
                    ->color('primary')
                    ->columnSpan(2),

                TextEntry::make('eventCategory.name')
                    ->label('Kategori')
                    ->badge()
                    ->icon('heroicon-o-tag')
                    ->columnSpan(1),

                TextEntry::make('event_type')
                    ->label('Jenis Event')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->icon('heroicon-o-building-office')
                    ->columnSpan(1),

                TextEntry::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'cancelled' => 'Cancelled',
                        'finished' => 'Finished',
                        default => ucfirst($state),
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'draft' => 'heroicon-o-document',
                        'published' => 'heroicon-o-check-circle',
                        'cancelled' => 'heroicon-o-x-circle',
                        'finished' => 'heroicon-o-flag',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->columnSpan(1),

                IconEntry::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->columnSpan(1),

                IconEntry::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->columnSpan(1),

                IconEntry::make('is_trending')
                    ->label('Trending')
                    ->boolean()
                    ->trueIcon('heroicon-o-fire')
                    ->falseIcon('heroicon-o-fire')
                    ->columnSpan(1),

                TextEntry::make('short_description')
                    ->label('Deskripsi Singkat')
                    ->icon('heroicon-o-document-text')
                    ->columnSpanFull(),

                TextEntry::make('description')
                    ->label('Deskripsi Lengkap')
                    ->html()
                    ->icon('heroicon-o-document')
                    ->columnSpanFull(),

                TextEntry::make('start_date')
                    ->label('Tanggal Mulai')
                    ->date('l, d F Y')
                    ->icon('heroicon-o-calendar')
                    ->columnSpan(1),

                TextEntry::make('end_date')
                    ->label('Tanggal Selesai')
                    ->date('l, d F Y')
                    ->icon('heroicon-o-calendar')
                    ->columnSpan(1),

                TextEntry::make('start_time')
                    ->label('Jam Mulai')
                    ->formatStateUsing(fn (?string $state): string => $state ? substr($state, 0, 5) . ' WIB' : '-')
                    ->icon('heroicon-o-clock')
                    ->columnSpan(1),

                TextEntry::make('location')
                    ->label('Lokasi')
                    ->icon('heroicon-o-map-pin')
                    ->columnSpan(1),

                TextEntry::make('city')
                    ->label('Kota')
                    ->icon('heroicon-o-building-storefront')
                    ->columnSpan(1),

                TextEntry::make('venue')
                    ->label('Venue')
                    ->icon('heroicon-o-building-office-2')
                    ->columnSpan(1),

                TextEntry::make('price')
                    ->label('Harga')
                    ->formatStateUsing(fn ($record): string => 
                        $record->is_free ? 'GRATIS' : 'Rp ' . number_format($record->price, 0, ',', '.')
                    )
                    ->size('lg')
                    ->weight('bold')
                    ->icon(fn ($record): string => $record->is_free ? 'heroicon-o-gift' : 'heroicon-o-banknotes')
                    ->columnSpan(1),

                TextEntry::make('current_participants')
                    ->label('Peserta Terdaftar')
                    ->formatStateUsing(fn ($record): string => 
                        number_format($record->current_participants) . ' / ' . number_format($record->max_participants ?? $record->quota)
                    )
                    ->icon('heroicon-o-users')
                    ->columnSpan(1),

                TextEntry::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state): string => 
                        $state > 0 ? number_format($state, 1) . ' / 5.0' : 'Belum ada rating'
                    )
                    ->icon('heroicon-o-star')
                    ->columnSpan(1),

                TextEntry::make('organizer_name')
                    ->label('Penyelenggara')
                    ->icon('heroicon-o-building-office')
                    ->columnSpan(1),

                TextEntry::make('contact_email')
                    ->label('Email')
                    ->icon('heroicon-o-envelope')
                    ->copyable()
                    ->columnSpan(1),

                TextEntry::make('contact_phone')
                    ->label('Telepon')
                    ->icon('heroicon-o-phone')
                    ->copyable()
                    ->columnSpan(1),

                TextEntry::make('slug')
                    ->label('Slug')
                    ->icon('heroicon-o-link')
                    ->copyable()
                    ->columnSpan(2),

                TextEntry::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d F Y, H:i')
                    ->icon('heroicon-o-calendar')
                    ->columnSpan(1),

                TextEntry::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d F Y, H:i')
                    ->icon('heroicon-o-clock')
                    ->columnSpan(1),
            ]);
    }
}
