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
use App\Enums\ProvinsiEnum;

class RegionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                // Basic Information - Row 1
                TextInput::make('region_name')
                    ->label('Nama Wilayah')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Contoh: DPW Jakarta Selatan')
                    ->columnSpan(2)
                    ->helperText('Nama resmi Dewan Pimpinan Wilayah'),

                Select::make('province')
                    ->label('Provinsi')
                    ->required()
                    ->options(ProvinsiEnum::toArray())
                    ->searchable()
                    ->placeholder('Pilih Provinsi')
                    ->native(false),
                    
                Select::make('dpc_name')
                    ->label('Nama DPC (Kota/Kabupaten)')
                    ->options(function (callable $get) {
                        $province = $get('province');
                        if (!$province) return [];
                        return array_combine(
                            \App\Enums\ProvinsiEnum::getKotaKabupaten($province),
                            \App\Enums\ProvinsiEnum::getKotaKabupaten($province)
                        );
                    })
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->live()
                    ->disabled(fn (callable $get) => !$get('province'))
                    ->placeholder('Pilih Kota/Kabupaten dari provinsi')
                    ->helperText('Daftar DPC (ibukota & kabupaten) diisi otomatis berdasarkan provinsi'),


                DatePicker::make('establishment_date')
                    ->label('Tanggal Pendirian')
                    ->maxDate(now())
                    ->displayFormat('d/m/Y')
                    ->helperText('Tanggal resmi pendirian DPW'),

                // Contact Information - Row 2
                TextInput::make('contact_email')
                    ->label('Email Kontak')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->placeholder('dpw@hastanaindonesia.id')
                    ->suffixIcon('heroicon-m-envelope')
                    ->helperText('Email resmi untuk komunikasi DPW'),

                TextInput::make('contact_phone')
                    ->label('Telepon Kontak')
                    ->tel()
                    ->required()
                    ->maxLength(20)
                    ->placeholder('+62 21 1234 5678')
                    ->suffixIcon('heroicon-m-phone')
                    ->helperText('Nomor telepon yang bisa dihubungi'),

                TextInput::make('website')
                    ->label('Website DPW')
                    ->url()
                    ->maxLength(255)
                    ->placeholder('https://dpw-jakarta.hastanaindonesia.id')
                    ->columnSpan(2)
                    ->suffixIcon('heroicon-m-globe-alt')
                    ->helperText('Website resmi DPW (opsional)'),

                // Address Information - Row 3
                Textarea::make('address')
                    ->label('Alamat Kantor')
                    ->placeholder('Alamat lengkap kantor DPW beserta nomor gedung dan lantai')
                    ->rows(3)
                    ->required()
                    ->columnSpan(1)
                    ->helperText('Alamat lengkap untuk keperluan surat menyurat'),

                TextInput::make('postal_code')
                    ->label('Kode Pos')
                    ->maxLength(10)
                    ->placeholder('12345')
                    ->numeric()
                    ->minLength(5)
                    ->helperText('Kode pos wilayah kantor DPW'),

                // Status and Description - Row 4
                Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->default(true)
                    ->helperText('DPW yang aktif akan ditampilkan di website public')
                    ->columnSpan(2)
                    ->inline(false),

                Textarea::make('description')
                    ->label('Deskripsi Wilayah')
                    ->placeholder('Deskripsi singkat tentang wilayah dan aktivitas DPW')
                    ->rows(4)
                    ->columnSpan(2)
                    ->helperText('Deskripsikan wilayah kerja dan kegiatan utama DPW'),

                // Leadership Structure - Row 5
                Select::make('ketua_dpw')
                    ->label('Ketua DPW')
                    ->options(User::whereIn('role', ['admin', 'member'])->pluck('name', 'id'))
                    ->searchable()
                    ->placeholder('Pilih Ketua DPW')
                    ->helperText('Ketua Dewan Pimpinan Wilayah')
                    ->native(false)
                    ->preload(),

                Select::make('wk_ketua_dpw')
                    ->label('Wakil Ketua DPW')
                    ->options(User::whereIn('role', ['admin', 'member'])->pluck('name', 'id'))
                    ->searchable()
                    ->placeholder('Pilih Wakil Ketua DPW')
                    ->helperText('Wakil Ketua Dewan Pimpinan Wilayah')
                    ->native(false)
                    ->preload(),

                Select::make('sekretaris_dpw')
                    ->label('Sekretaris DPW')
                    ->options(User::whereIn('role', ['admin', 'member'])->pluck('name', 'id'))
                    ->searchable()
                    ->placeholder('Pilih Sekretaris DPW')
                    ->helperText('Sekretaris Dewan Pimpinan Wilayah')
                    ->native(false)
                    ->preload(),

                Select::make('bendahara_dpw')
                    ->label('Bendahara DPW')
                    ->options(User::whereIn('role', ['admin', 'member'])->pluck('name', 'id'))
                    ->searchable()
                    ->placeholder('Pilih Bendahara DPW')
                    ->helperText('Bendahara Dewan Pimpinan Wilayah')
                    ->native(false)
                    ->preload(),

                // Logo Upload - Row 6
                FileUpload::make('logo')
                    ->label('Logo DPW')
                    ->disk('public')
                    ->directory('region-logos')
                    ->image()
                    ->maxSize(2048)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '1:1',
                        '16:9',
                        '4:3',
                    ])
                    ->helperText('Upload logo resmi DPW (maksimal 2MB, format: JPG, PNG, WebP)')
                    ->columnSpan(2),
            ]);
    }
}
