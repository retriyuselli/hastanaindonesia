<?php

namespace App\Filament\Admin\Resources\Galleries\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class GalleryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                ImageEntry::make('image'),
                TextEntry::make('category'),
                TextEntry::make('date')
                    ->date(),
                TextEntry::make('location'),
                TextEntry::make('photographer'),
                TextEntry::make('company_id')
                    ->numeric(),
                TextEntry::make('views_count')
                    ->numeric(),
                IconEntry::make('is_featured')
                    ->boolean(),
                IconEntry::make('is_published')
                    ->boolean(),
                TextEntry::make('slug'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                TextEntry::make('deleted_at')
                    ->dateTime(),
            ]);
    }
}
