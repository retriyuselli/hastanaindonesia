<?php

namespace App\Filament\Admin\Resources\Regions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use App\Models\User;

class RegionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                // Basic Information
                TextInput::make('region_name')
                    ->label('Nama Wilayah')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Contoh: DPW Jakarta Selatan')
                    ->columnSpan(2),

                TextInput::make('province')
                    ->label('Provinsi')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('Contoh: DKI Jakarta')
                    ->datalist([
                        'Aceh',
                        'Sumatera Utara',
                        'Sumatera Barat',
                        'Riau',
                        'Kepulauan Riau',
                        'Jambi',
                        'Sumatera Selatan',
                        'Bangka Belitung',
                        'Bengkulu',
                        'Lampung',
                        'DKI Jakarta',
                        'Jawa Barat',
                        'Jawa Tengah',
                        'DI Yogyakarta',
                        'Jawa Timur',
                        'Banten',
                        'Bali',
                        'Nusa Tenggara Barat',
                        'Nusa Tenggara Timur',
                        'Kalimantan Barat',
                        'Kalimantan Tengah',
                        'Kalimantan Selatan',
                        'Kalimantan Timur',
                        'Kalimantan Utara',
                        'Sulawesi Utara',
                        'Sulawesi Tengah',
                        'Sulawesi Selatan',
                        'Sulawesi Tenggara',
                        'Gorontalo',
                        'Sulawesi Barat',
                        'Maluku',
                        'Maluku Utara',
                        'Papua',
                        'Papua Barat',
                    ]),

                TextInput::make('contact_email')
                    ->label('Email Kontak')
                    ->email()
                    ->maxLength(255)
                    ->placeholder('dpw@hastana.or.id')
                    ->suffixIcon('heroicon-m-envelope'),

                TextInput::make('contact_phone')
                    ->label('Telepon Kontak')
                    ->tel()
                    ->maxLength(20)
                    ->placeholder('+62 21 1234 5678')
                    ->suffixIcon('heroicon-m-phone'),

                TextInput::make('website')
                    ->label('Website')
                    ->url()
                    ->maxLength(255)
                    ->placeholder('https://dpw-jakarta.hastana.or.id')
                    ->columnSpan(2),

                Textarea::make('address')
                    ->label('Alamat Kantor')
                    ->placeholder('Alamat lengkap kantor DPW')
                    ->rows(2)
                    ->columnSpan(2),

                TextInput::make('postal_code')
                    ->label('Kode Pos')
                    ->maxLength(10)
                    ->placeholder('12345')
                    ->numeric(),

                DatePicker::make('establishment_date')
                    ->label('Tanggal Pendirian')
                    ->maxDate(now())
                    ->displayFormat('d/m/Y'),

                Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->default(true)
                    ->helperText('DPW yang aktif akan ditampilkan di public')
                    ->columnSpan(2),

                Textarea::make('description')
                    ->label('Deskripsi Wilayah')
                    ->placeholder('Deskripsi singkat tentang wilayah dan aktivitas DPW')
                    ->rows(3)
                    ->columnSpan(2),

                FileUpload::make('logo')
                    ->label('Logo DPW')
                    ->disk('public')
                    ->directory('region-logos')
                    ->image()
                    ->maxSize(2048)
                    ->acceptedFileTypes(['image/jpeg', 'image/png'])
                    ->columnSpan(2),

                // DPW Leadership Structure
                Select::make('ketua_dpw')
                    ->label('Ketua DPW')
                    ->options(User::where('role', 'member')->pluck('name', 'id'))
                    ->searchable()
                    ->placeholder('Pilih Ketua DPW')
                    ->helperText('Ketua Dewan Pimpinan Wilayah'),

                Select::make('wk_ketua_dpw')
                    ->label('Wakil Ketua DPW')
                    ->options(User::where('role', 'member')->pluck('name', 'id'))
                    ->searchable()
                    ->placeholder('Pilih Wakil Ketua DPW')
                    ->helperText('Wakil Ketua Dewan Pimpinan Wilayah'),

                Select::make('sekretaris_dpw')
                    ->label('Sekretaris DPW')
                    ->options(User::where('role', 'member')->pluck('name', 'id'))
                    ->searchable()
                    ->placeholder('Pilih Sekretaris DPW')
                    ->helperText('Sekretaris Dewan Pimpinan Wilayah'),

                Select::make('bendahara_dpw')
                    ->label('Bendahara DPW')
                    ->options(User::where('role', 'member')->pluck('name', 'id'))
                    ->searchable()
                    ->placeholder('Pilih Bendahara DPW')
                    ->helperText('Bendahara Dewan Pimpinan Wilayah'),
            ]);
    }
}
