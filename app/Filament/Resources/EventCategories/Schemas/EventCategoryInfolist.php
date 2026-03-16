<?php

namespace App\Filament\Resources\EventCategories\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class EventCategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextEntry::make('name')
                    ->label('🏷️ Nama')
                    ->weight('bold')
                    ->size('lg')
                    ->columnSpanFull(),
                TextEntry::make('slug')
                    ->label('🔗 Slug')
                    ->badge()
                    ->color('gray'),
                IconEntry::make('is_active')
                    ->label('✅ Aktif')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                TextEntry::make('description')
                    ->label('📝 Deskripsi')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('icon')
                    ->label('🎯 Icon')
                    ->html()
                    ->formatStateUsing(function (?string $state): HtmlString {
                        if (! $state) {
                            return new HtmlString('-');
                        }

                        $value = (string) $state;
                        $safeValue = e($value);

                        if (str_starts_with($value, 'heroicon-')) {
                            return new HtmlString('<span class="font-mono">'.$safeValue.'</span>');
                        }

                        $class = str_contains($value, ' ') ? $value : ('fas fa-'.$value);
                        $safeClass = e($class);

                        return new HtmlString('<span class="inline-flex items-center gap-2"><i class="'.$safeClass.'"></i><span class="font-mono">'.$safeValue.'</span></span>');
                    }),
                TextEntry::make('color')
                    ->label('🌈 Warna')
                    ->html()
                    ->formatStateUsing(function (?string $state): HtmlString {
                        $color = $state ?: '#3B82F6';
                        $safe = e($color);

                        return new HtmlString('<span class="inline-flex items-center gap-2"><span class="w-3 h-3 rounded-full" style="background: '.$safe.'"></span><span class="font-mono">'.$safe.'</span></span>');
                    }),
                TextEntry::make('sort_order')
                    ->label('🔢 Urutan')
                    ->numeric()
                    ->badge()
                    ->color('gray'),
                TextEntry::make('created_at')
                    ->label('🕒 Dibuat')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->label('🕒 Diperbarui')
                    ->dateTime(),
            ]);
    }
}
