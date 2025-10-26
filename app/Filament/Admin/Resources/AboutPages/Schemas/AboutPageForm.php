<?php

namespace App\Filament\Admin\Resources\AboutPages\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;

class AboutPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->helperText('Hanya satu halaman yang bisa aktif pada satu waktu')
                    ->default(true)
                    ->columnSpanFull(),

                RichEditor::make('history')
                    ->label('Sejarah HASTANA')
                    ->placeholder('Tulis sejarah HASTANA Indonesia...')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'bulletList',
                        'orderedList',
                        'h2',
                        'h3',
                        'link',
                    ])
                    ->columnSpanFull(),

                Textarea::make('vision')
                    ->label('Visi')
                    ->placeholder('Tulis visi HASTANA Indonesia...')
                    ->rows(3)
                    ->columnSpanFull(),

                RichEditor::make('mission')
                    ->label('Misi')
                    ->placeholder('Tulis misi HASTANA Indonesia...')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'bulletList',
                        'orderedList',
                    ])
                    ->columnSpanFull(),

                Repeater::make('values')
                    ->label('Nilai-nilai HASTANA')
                    ->schema([
                        TextInput::make('title')
                            ->label('Nama Nilai')
                            ->placeholder('Contoh: Profesionalisme')
                            ->required()
                            ->maxLength(100),
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->placeholder('Jelaskan nilai ini...')
                            ->required()
                            ->rows(3)
                            ->maxLength(500),
                    ])
                    ->columns(1)
                    ->defaultItems(0)
                    ->addActionLabel('Tambah Nilai')
                    ->reorderable()
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                    ->columnSpanFull(),

                Repeater::make('programs')
                    ->label('Program dan Layanan')
                    ->schema([
                        TextInput::make('title')
                            ->label('Nama Program/Layanan')
                            ->placeholder('Contoh: Sertifikasi Wedding Organizer')
                            ->required()
                            ->maxLength(150),
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->placeholder('Jelaskan program/layanan ini...')
                            ->required()
                            ->rows(4)
                            ->maxLength(1000),
                    ])
                    ->columns(1)
                    ->defaultItems(0)
                    ->addActionLabel('Tambah Program/Layanan')
                    ->reorderable()
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                    ->columnSpanFull(),
            ]);
    }
}
