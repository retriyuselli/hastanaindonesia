<?php

namespace App\Filament\Resources\IuranSettings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class IuranSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Informasi Iuran')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label('Nama Iuran')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Contoh: Iuran Bulanan Januari 2025')
                        ->columnSpan(2),

                    Textarea::make('description')
                        ->label('Keterangan')
                        ->rows(3)
                        ->nullable()
                        ->columnSpan(2),

                    TextInput::make('amount')
                        ->label('Nominal (Rp)')
                        ->numeric()
                        ->required()
                        ->minValue(0)
                        ->prefix('Rp')
                        ->columnSpan(1),

                    Select::make('period_type')
                        ->label('Jenis Periode')
                        ->options([
                            'monthly' => 'Bulanan',
                            'yearly'  => 'Tahunan',
                        ])
                        ->required()
                        ->live()
                        ->columnSpan(1),

                    TextInput::make('year')
                        ->label('Tahun')
                        ->numeric()
                        ->required()
                        ->minValue(2020)
                        ->maxValue(2100)
                        ->default(now()->year)
                        ->columnSpan(1),

                    Select::make('month')
                        ->label('Bulan')
                        ->options([
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                            4 => 'April',   5 => 'Mei',      6 => 'Juni',
                            7 => 'Juli',    8 => 'Agustus',  9 => 'September',
                            10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                        ])
                        ->nullable()
                        ->visible(fn ($get) => $get('period_type') === 'monthly')
                        ->required(fn ($get) => $get('period_type') === 'monthly')
                        ->columnSpan(1),

                    DatePicker::make('due_date')
                        ->label('Tanggal Jatuh Tempo')
                        ->required()
                        ->displayFormat('d M Y')
                        ->columnSpan(1),

                    Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true)
                        ->columnSpan(1),
                ]),
        ]);
    }
}
