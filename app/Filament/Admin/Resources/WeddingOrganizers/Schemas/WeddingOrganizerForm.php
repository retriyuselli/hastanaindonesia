<?php

namespace App\Filament\Admin\Resources\WeddingOrganizers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use App\Models\User;
use App\Models\Region;

class WeddingOrganizerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                // Basic Information
                Select::make('user_id')
                    ->label('Pengguna')
                    ->options(User::pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->placeholder('Pilih pengguna')
                    ->helperText('User yang terkait dengan wedding organizer ini'),

                Select::make('region_id')
                    ->label('Wilayah')
                    ->options(Region::pluck('region_name', 'id'))
                    ->required()
                    ->searchable()
                    ->placeholder('Pilih wilayah')
                    ->helperText('Wilayah operasional wedding organizer'),

                TextInput::make('organizer_name')
                    ->label('Nama Wedding Organizer')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Nama lengkap wedding organizer')
                    ->columnSpan(2),

                TextInput::make('brand_name')
                    ->label('Nama Brand')
                    ->maxLength(255)
                    ->placeholder('Nama brand/perusahaan')
                    ->columnSpan(2),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->placeholder('Deskripsi layanan dan keunggulan wedding organizer')
                    ->rows(3)
                    ->columnSpan(2),

                // Contact Information
                TextInput::make('phone')
                    ->label('Telepon')
                    ->tel()
                    ->maxLength(20)
                    ->placeholder('+62 812 3456 7890'),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->maxLength(255)
                    ->placeholder('organizer@example.com')
                    ->unique(ignoreRecord: true),

                TextInput::make('website')
                    ->label('Website')
                    ->url()
                    ->maxLength(255)
                    ->placeholder('https://www.organizer.com'),

                TextInput::make('instagram')
                    ->label('Instagram')
                    ->maxLength(255)
                    ->placeholder('@organizer_instagram')
                    ->prefixIcon('heroicon-m-camera'),

                // Address Information
                Textarea::make('address')
                    ->label('Alamat')
                    ->required()
                    ->placeholder('Alamat lengkap kantor/studio')
                    ->rows(2)
                    ->columnSpan(2),

                TextInput::make('city')
                    ->label('Kota')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('Jakarta'),

                TextInput::make('province')
                    ->label('Provinsi')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('DKI Jakarta')
                    ->datalist([
                        'Aceh', 'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Kepulauan Riau',
                        'Jambi', 'Sumatera Selatan', 'Bangka Belitung', 'Bengkulu', 'Lampung',
                        'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'DI Yogyakarta', 'Jawa Timur',
                        'Banten', 'Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
                        'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara',
                        'Sulawesi Utara', 'Sulawesi Tengah', 'Sulawesi Selatan', 'Sulawesi Tenggara', 'Gorontalo', 'Sulawesi Barat',
                        'Maluku', 'Maluku Utara', 'Papua', 'Papua Barat'
                    ]),

                TextInput::make('postal_code')
                    ->label('Kode Pos')
                    ->maxLength(10)
                    ->placeholder('12345')
                    ->numeric(),

                // Professional Information
                Select::make('certification_level')
                    ->label('Level Sertifikasi')
                    ->options([
                        'basic' => '🥉 Basic',
                        'intermediate' => '🥈 Intermediate', 
                        'advanced' => '🥇 Advanced',
                        'expert' => '👑 Expert',
                    ])
                    ->placeholder('Pilih level sertifikasi')
                    ->helperText('Level kompetensi berdasarkan sertifikasi'),

                TextInput::make('established_year')
                    ->label('Tahun Berdiri')
                    ->numeric()
                    ->minValue(1980)
                    ->maxValue(date('Y'))
                    ->placeholder('2020'),

                Select::make('business_type')
                    ->label('Jenis Usaha')
                    ->options([
                        'individual' => 'Perorangan',
                        'partnership' => 'Partnership',
                        'company' => 'Perusahaan'
                    ])
                    ->default('individual')
                    ->required(),

                TextInput::make('business_license')
                    ->label('Izin Usaha')
                    ->maxLength(100)
                    ->placeholder('Nomor SIUP/NIB'),

                Textarea::make('specializations')
                    ->label('Spesialisasi')
                    ->placeholder('Traditional, Modern, Outdoor, Indoor, etc.')
                    ->rows(2)
                    ->columnSpan(2),

                Textarea::make('services')
                    ->label('Layanan')
                    ->placeholder('Planning, Decoration, Catering, Photography, etc.')
                    ->rows(2)
                    ->columnSpan(2),

                // Pricing & Performance
                TextInput::make('price_range_min')
                    ->label('Harga Minimum')
                    ->numeric()
                    ->prefix('Rp')
                    ->placeholder('50000000')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.')),

                TextInput::make('price_range_max')
                    ->label('Harga Maksimum')
                    ->numeric()
                    ->prefix('Rp')
                    ->placeholder('500000000')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.')),

                TextInput::make('completed_events')
                    ->label('Event Selesai')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->suffix('events'),

                TextInput::make('rating')
                    ->label('Rating')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(5)
                    ->step(0.1)
                    ->suffix('/ 5.0'),

                Textarea::make('awards')
                    ->label('Penghargaan')
                    ->placeholder('List penghargaan yang pernah diterima')
                    ->rows(2)
                    ->columnSpan(2),

                // Status & Verification
                Select::make('verification_status')
                    ->label('Status Verifikasi')
                    ->options([
                        'pending' => '⏳ Pending',
                        'verified' => '✅ Verified',
                        'rejected' => '❌ Rejected'
                    ])
                    ->default('pending')
                    ->required()
                    ->live(),

                Toggle::make('is_featured')
                    ->label('Featured')
                    ->helperText('Tampilkan di halaman utama'),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => '🟢 Active',
                        'inactive' => '🔴 Inactive',
                        'suspended' => '🟡 Suspended'
                    ])
                    ->default('active')
                    ->required(),

                DateTimePicker::make('verified_at')
                    ->label('Tanggal Verifikasi')
                    ->visible(fn (callable $get) => in_array($get('verification_status'), ['verified', 'rejected'])),

                Select::make('verified_by')
                    ->label('Diverifikasi Oleh')
                    ->options(User::where('role', 'admin')->pluck('name', 'id'))
                    ->placeholder('Pilih admin verifikator')
                    ->visible(fn (callable $get) => in_array($get('verification_status'), ['verified', 'rejected'])),

                // Legal Documents
                Select::make('legal_entity_type')
                    ->label('Jenis Badan Usaha')
                    ->options([
                        'PT' => 'Perseroan Terbatas (PT)',
                        'CV' => 'Commanditaire Vennootschap (CV)',
                        'Firma' => 'Firma',
                        'UD' => 'Usaha Dagang (UD)',
                        'Koperasi' => 'Koperasi',
                        'Yayasan' => 'Yayasan',
                    ])
                    ->placeholder('Pilih jenis badan usaha')
                    ->columnSpan(2),

                TextInput::make('deed_of_establishment')
                    ->label('Nomor Akta Pendirian')
                    ->maxLength(100)
                    ->placeholder('No. 123/2020'),

                DatePicker::make('deed_date')
                    ->label('Tanggal Akta')
                    ->maxDate(now()),

                TextInput::make('notary_name')
                    ->label('Nama Notaris')
                    ->maxLength(255)
                    ->placeholder('Dr. John Doe, S.H., M.Kn.'),

                TextInput::make('notary_license_number')
                    ->label('Nomor Izin Notaris')
                    ->maxLength(100)
                    ->placeholder('123/KEP/2020'),

                TextInput::make('nib_number')
                    ->label('Nomor NIB')
                    ->maxLength(100)
                    ->placeholder('1234567890123'),

                DatePicker::make('nib_issued_date')
                    ->label('Tanggal Terbit NIB')
                    ->maxDate(now()),

                DatePicker::make('nib_valid_until')
                    ->label('NIB Berlaku Sampai')
                    ->minDate(now()),

                TextInput::make('npwp_number')
                    ->label('Nomor NPWP')
                    ->maxLength(20)
                    ->placeholder('12.345.678.9-012.000'),

                DatePicker::make('npwp_issued_date')
                    ->label('Tanggal Terbit NPWP')
                    ->maxDate(now()),

                TextInput::make('tax_office')
                    ->label('Kantor Pajak')
                    ->maxLength(255)
                    ->placeholder('KPP Pratama Jakarta Selatan')
                    ->columnSpan(2),

                Select::make('legal_document_status')
                    ->label('Status Dokumen Legal')
                    ->options([
                        'incomplete' => '❌ Tidak Lengkap',
                        'pending_review' => '⏳ Menunggu Review',
                        'verified' => '✅ Terverifikasi',
                        'rejected' => '🚫 Ditolak',
                    ])
                    ->default('incomplete')
                    ->required()
                    ->live(),

                Textarea::make('legal_document_notes')
                    ->label('Catatan Dokumen Legal')
                    ->placeholder('Catatan reviewer mengenai dokumen legal')
                    ->rows(3)
                    ->visible(fn (callable $get) => in_array($get('legal_document_status'), ['verified', 'rejected']))
                    ->columnSpan(2),

                DateTimePicker::make('legal_verified_at')
                    ->label('Tanggal Verifikasi Legal')
                    ->visible(fn (callable $get) => in_array($get('legal_document_status'), ['verified', 'rejected'])),

                Select::make('legal_verified_by')
                    ->label('Legal Diverifikasi Oleh')
                    ->options(User::where('role', 'admin')->pluck('name', 'id'))
                    ->placeholder('Pilih admin verifikator')
                    ->visible(fn (callable $get) => in_array($get('legal_document_status'), ['verified', 'rejected'])),

                FileUpload::make('legal_documents')
                    ->label('Dokumen Legal')
                    ->disk('public')
                    ->directory('wedding-organizer-documents')
                    ->multiple()
                    ->acceptedFileTypes(['application/pdf', 'image/*'])
                    ->maxSize(5120)
                    ->columnSpan(2),
            ]);
    }
}
