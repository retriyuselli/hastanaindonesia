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
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Support\Facades\Auth;

class WeddingOrganizerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Wedding Organizer Tabs')
                    ->columnSpanFull()
                    ->tabs([
                        // Tab 1: Informasi Pengguna & Wilayah
                        Tab::make('Pengguna & Wilayah')
                            ->icon('heroicon-o-user-circle')
                            ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('user_id')
                                    ->label('Pengguna')
                                    ->options(User::pluck('name', 'id'))
                                    ->required()
                                    ->searchable()
                                    ->placeholder('Pilih pengguna')
                                    ->helperText('User yang terkait dengan wedding organizer ini')
                                    ->prefixIcon('heroicon-o-user'),

                                Select::make('region_id')
                                    ->label('Wilayah')
                                    ->options(Region::pluck('region_name', 'id'))
                                    ->nullable()
                                    ->searchable()
                                    ->placeholder('Pilih wilayah')
                                    ->helperText('Wilayah operasional wedding organizer (diisi oleh admin)')
                                    ->prefixIcon('heroicon-o-map-pin'),
                            ]),
                        ]), // End Tab Pengguna & Wilayah

                        // Tab 2: Informasi Dasar
                        Tab::make('Informasi Dasar')
                            ->icon('heroicon-o-building-office-2')
                            ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('organizer_name')
                                    ->label('Nama Wedding Organizer')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Contoh: Elegant Wedding Bali')
                                    ->prefixIcon('heroicon-o-sparkles')
                                    ->columnSpan(2)
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),

                                TextInput::make('slug')
                                    ->label('Slug (URL)')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('elegant-wedding-bali')
                                    ->prefixIcon('heroicon-o-link')
                                    ->columnSpan(2)
                                    ->unique(ignoreRecord: true)
                                    ->helperText('URL-friendly identifier (otomatis dibuat dari nama, bisa diubah)')
                                    ->rules(['regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/']),

                                TextInput::make('brand_name')
                                    ->label('Nama PT/CV (Optional)')
                                    ->maxLength(255)
                                    ->placeholder('Contoh: PT Elegant Wedding Indonesia')
                                    ->prefixIcon('heroicon-o-building-office')
                                    ->columnSpan(2),

                                Textarea::make('description')
                                    ->label('Deskripsi')
                                    ->placeholder('Deskripsikan layanan, keunggulan, dan pengalaman wedding organizer Anda...')
                                    ->rows(4)
                                    ->columnSpan(2)
                                    ->helperText('Maksimal 1000 karakter')
                                    ->maxLength(1000),

                                FileUpload::make('logo')
                                    ->label('Logo Wedding Organizer')
                                    ->disk('public')
                                    ->directory('wedding-organizer-logos')
                                    ->image()
                                    ->maxSize(2048)
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '1:1',
                                        '16:9',
                                        '4:3',
                                    ])
                                    ->openable()
                                    ->downloadable()
                                    ->previewable()
                                    ->columnSpan(2)
                                    ->helperText('Upload logo wedding organizer (Format: JPG, PNG, max 2MB). Rekomendasi: 500x500px atau rasio 1:1'),
                            ]),
                        ]), // End Tab Informasi Dasar

                        // Tab 3: Kontak & Lokasi
                        Tab::make('Kontak & Lokasi')
                            ->icon('heroicon-o-phone')
                            ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('phone')
                                    ->label('Nomor Telepon')
                                    ->tel()
                                    ->maxLength(20)
                                    ->placeholder('+62 812 3456 7890')
                                    ->prefixIcon('heroicon-o-phone')
                                    ->helperText('Format: +62 atau 08xx'),

                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->maxLength(255)
                                    ->placeholder('contact@organizer.com')
                                    ->prefixIcon('heroicon-o-envelope')
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Email akan digunakan untuk komunikasi resmi'),

                                TextInput::make('website')
                                    ->label('Website')
                                    ->url()
                                    ->maxLength(255)
                                    ->placeholder('https://www.organizer.com')
                                    ->prefixIcon('heroicon-o-globe-alt')
                                    ->helperText('URL lengkap dengan https://'),

                                TextInput::make('instagram')
                                    ->label('Instagram')
                                    ->maxLength(255)
                                    ->placeholder('@organizer_instagram')
                                    ->prefixIcon('heroicon-m-camera')
                                    ->helperText('Username Instagram tanpa atau dengan @'),

                                Textarea::make('address')
                                    ->label('Alamat Lengkap')
                                    ->required()
                                    ->placeholder('Jalan, Nomor, RT/RW, Kelurahan, Kecamatan')
                                    ->rows(3)
                                    ->columnSpan(2)
                                    ->helperText('Alamat lengkap kantor/studio untuk keperluan korespondensi'),

                                Select::make('province')
                                    ->label('Provinsi')
                                    ->required()
                                    ->searchable()
                                    ->options(config('indonesia.provinces'))
                                    ->placeholder('Pilih Provinsi')
                                    ->prefixIcon('heroicon-o-map')
                                    ->live()
                                    ->afterStateUpdated(fn (callable $set) => $set('city', null)),

                                Select::make('city')
                                    ->label('Kota/Kabupaten')
                                    ->required()
                                    ->searchable()
                                    ->options(function (callable $get) {
                                        $province = $get('province');
                                        if (!$province) {
                                            return [];
                                        }
                                        $cities = config('indonesia.cities')[$province] ?? [];
                                        return array_combine($cities, $cities);
                                    })
                                    ->placeholder('Pilih Kota')
                                    ->prefixIcon('heroicon-o-building-office-2')
                                    ->disabled(fn (callable $get) => !$get('province'))
                                    ->helperText('Pilih provinsi terlebih dahulu'),

                                TextInput::make('postal_code')
                                    ->label('Kode Pos')
                                    ->maxLength(10)
                                    ->placeholder('12345')
                                    ->numeric()
                                    ->prefixIcon('heroicon-o-map-pin')
                                    ->helperText('5 digit kode pos'),
                            ]),
                        ]), // End Tab Kontak & Lokasi

                        // Tab 4: Profesional & Bisnis
                        Tab::make('Profesional & Bisnis')
                            ->icon('heroicon-o-academic-cap')
                            ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('certification_level')
                                    ->label('Level Sertifikasi')
                                    ->options(config('indonesia.certification_levels'))
                                    ->placeholder('Pilih level sertifikasi')
                                    ->prefixIcon('heroicon-o-academic-cap')
                                    ->helperText('Level kompetensi berdasarkan sertifikasi HASTANA'),

                                TextInput::make('established_year')
                                    ->label('Tahun Berdiri')
                                    ->numeric()
                                    ->minValue(1980)
                                    ->maxValue(date('Y'))
                                    ->placeholder(date('Y'))
                                    ->prefixIcon('heroicon-o-calendar')
                                    ->helperText('Tahun mulai beroperasi'),

                                Select::make('business_type')
                                    ->label('Jenis Usaha')
                                    ->options(config('indonesia.business_types'))
                                    ->default('Perorangan')
                                    ->required()
                                    ->prefixIcon('heroicon-o-briefcase')
                                    ->helperText('Bentuk badan usaha'),

                                TextInput::make('business_license')
                                    ->label('Nomor Izin Usaha')
                                    ->maxLength(100)
                                    ->placeholder('Contoh: SIUP/NIB 1234567890')
                                    ->prefixIcon('heroicon-o-document-text')
                                    ->helperText('SIUP/NIB/TDP'),

                                Textarea::make('specializations')
                                    ->label('Spesialisasi')
                                    ->placeholder('Contoh: Traditional Javanese Wedding, Modern Minimalist, Beach Wedding, Garden Party')
                                    ->rows(3)
                                    ->columnSpan(2)
                                    ->helperText('Pisahkan dengan koma untuk setiap spesialisasi'),

                                Textarea::make('services')
                                    ->label('Layanan yang Ditawarkan')
                                    ->placeholder('Contoh: Full Wedding Planning, Decoration, Catering Coordination, Photography & Videography, Entertainment')
                                    ->rows(3)
                                    ->columnSpan(2)
                                    ->helperText('Pisahkan dengan koma untuk setiap layanan'),
                            ]),
                        ]), // End Tab Profesional & Bisnis

                        // Tab 5: Harga & Performa
                        Tab::make('Harga & Performa')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('price_range_min')
                                    ->label('Harga Minimum Paket')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->placeholder('10000000.00')
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->helperText('Contoh: 50000000 (50 juta)')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state) {
                                            // Format tampilan saat blur
                                            $formatted = number_format((float)$state, 2, '.', '');
                                            $set('price_range_min', $formatted);
                                        }
                                    }),

                                TextInput::make('price_range_max')
                                    ->label('Harga Maksimum Paket')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->placeholder('200000000.00')
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->helperText('Contoh: 500000000 (500 juta)')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state) {
                                            // Format tampilan saat blur
                                            $formatted = number_format((float)$state, 2, '.', '');
                                            $set('price_range_max', $formatted);
                                        }
                                    }),

                                TextInput::make('completed_events')
                                    ->label('Jumlah Event Selesai')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->suffix('events')
                                    ->prefixIcon('heroicon-o-calendar-days')
                                    ->helperText('Total event yang sudah ditangani'),

                                TextInput::make('rating')
                                    ->label('Rating')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(5)
                                    ->step(0.1)
                                    ->suffix('/ 5.0')
                                    ->prefixIcon('heroicon-o-star')
                                    ->helperText('Rating dari customer (0-5)'),

                                Textarea::make('awards')
                                    ->label('Penghargaan & Prestasi')
                                    ->placeholder('Contoh: Best Wedding Organizer 2024, Most Creative Decoration 2023')
                                    ->rows(3)
                                    ->columnSpan(2)
                                    ->helperText('List penghargaan yang pernah diterima'),
                            ]),
                        ]), // End Tab Harga & Performa

                        // Tab 6: Status & Verifikasi (Admin Only)
                        Tab::make('Status & Verifikasi')
                            ->icon('heroicon-o-shield-check')
                            ->visible(fn () => Auth::check() && Auth::user()->role === 'admin')
                            ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('verification_status')
                                    ->label('Status Verifikasi')
                                    ->options([
                                        'pending' => '⏳ Pending',
                                        'verified' => '✅ Verified',
                                        'rejected' => '❌ Rejected'
                                    ])
                                    ->default('pending')
                                    ->required()
                                    ->live()
                                    ->prefixIcon('heroicon-o-check-badge'),

                                Select::make('status')
                                    ->label('Status Operasional')
                                    ->options([
                                        'active' => '🟢 Active',
                                        'inactive' => '🔴 Inactive',
                                        'suspended' => '🟡 Suspended'
                                    ])
                                    ->default('active')
                                    ->required()
                                    ->prefixIcon('heroicon-o-signal'),

                                Toggle::make('is_featured')
                                    ->label('Featured')
                                    ->helperText('Tampilkan di halaman utama sebagai recommended')
                                    ->inline(false)
                                    ->columnSpan(2),

                                DateTimePicker::make('verified_at')
                                    ->label('Tanggal Verifikasi')
                                    ->visible(fn (callable $get) => in_array($get('verification_status'), ['verified', 'rejected']))
                                    ->prefixIcon('heroicon-o-calendar'),

                                Select::make('verified_by')
                                    ->label('Diverifikasi Oleh')
                                    ->options(User::where('role', 'admin')->pluck('name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->default(fn () => Auth::id())
                                    ->afterStateHydrated(function ($component, $state) {
                                        if (!$state && Auth::check() && Auth::user()->role === 'admin') {
                                            $component->state(Auth::id());
                                        }
                                    })
                                    ->disabled()
                                    ->dehydrated()
                                    ->visible(fn (callable $get) => in_array($get('verification_status'), ['verified', 'rejected']))
                                    ->prefixIcon('heroicon-o-user'),
                            ]),
                        ]), // End Tab Status & Verifikasi

                        // Tab 7: Dokumen Legal
                        Tab::make('Dokumen Legal')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                        Grid::make(2)
                            ->schema([
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
                                    ->prefixIcon('heroicon-o-building-library')
                                    ->columnSpan(2),

                                TextInput::make('deed_of_establishment')
                                    ->label('Nomor Akta Pendirian')
                                    ->maxLength(100)
                                    ->placeholder('Contoh: No. 123/2020')
                                    ->prefixIcon('heroicon-o-document'),

                                DatePicker::make('deed_date')
                                    ->label('Tanggal Akta')
                                    ->maxDate(now())
                                    ->prefixIcon('heroicon-o-calendar'),

                                TextInput::make('notary_name')
                                    ->label('Nama Notaris')
                                    ->maxLength(255)
                                    ->placeholder('Contoh: Dr. John Doe, S.H., M.Kn.')
                                    ->prefixIcon('heroicon-o-user-circle'),

                                TextInput::make('notary_license_number')
                                    ->label('Nomor Izin Notaris')
                                    ->maxLength(100)
                                    ->placeholder('Contoh: 123/KEP/2020')
                                    ->prefixIcon('heroicon-o-identification'),

                                TextInput::make('nib_number')
                                    ->label('Nomor NIB (Nomor Induk Berusaha)')
                                    ->maxLength(100)
                                    ->placeholder('Contoh: 1234567890123')
                                    ->prefixIcon('heroicon-o-clipboard-document-check')
                                    ->helperText('13 digit NIB dari OSS'),

                                DatePicker::make('nib_issued_date')
                                    ->label('Tanggal Terbit NIB')
                                    ->maxDate(now())
                                    ->prefixIcon('heroicon-o-calendar'),

                                DatePicker::make('nib_valid_until')
                                    ->label('NIB Berlaku Sampai')
                                    ->minDate(now())
                                    ->prefixIcon('heroicon-o-calendar-days'),

                                TextInput::make('npwp_number')
                                    ->label('Nomor NPWP')
                                    ->maxLength(20)
                                    ->placeholder('Contoh: 12.345.678.9-012.000')
                                    ->prefixIcon('heroicon-o-credit-card')
                                    ->helperText('Format: XX.XXX.XXX.X-XXX.XXX'),

                                DatePicker::make('npwp_issued_date')
                                    ->label('Tanggal Terbit NPWP')
                                    ->maxDate(now())
                                    ->prefixIcon('heroicon-o-calendar'),

                                TextInput::make('tax_office')
                                    ->label('Kantor Pajak Terdaftar')
                                    ->maxLength(255)
                                    ->placeholder('Contoh: KPP Pratama Jakarta Selatan')
                                    ->prefixIcon('heroicon-o-building-office')
                                    ->columnSpan(2),
                            ]),
                        ]), // End Tab Dokumen Legal

                        // Tab 8: Verifikasi Legal (Admin Only)
                        Tab::make('Verifikasi Legal')
                            ->icon('heroicon-o-clipboard-document-check')
                            ->visible(fn () => Auth::check() && Auth::user()->role === 'admin')
                            ->schema([
                        Grid::make(2)
                            ->schema([
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
                                    ->live()
                                    ->prefixIcon('heroicon-o-document-check')
                                    ->columnSpan(2),

                                Textarea::make('legal_document_notes')
                                    ->label('Catatan Verifikasi')
                                    ->placeholder('Catatan reviewer mengenai dokumen legal (alasan verifikasi/penolakan)')
                                    ->rows(3)
                                    ->visible(fn (callable $get) => in_array($get('legal_document_status'), ['verified', 'rejected']))
                                    ->columnSpan(2),

                                DateTimePicker::make('legal_verified_at')
                                    ->label('Tanggal Verifikasi Legal')
                                    ->visible(fn (callable $get) => in_array($get('legal_document_status'), ['verified', 'rejected']))
                                    ->prefixIcon('heroicon-o-calendar'),

                                Select::make('legal_verified_by')
                                    ->label('Legal Diverifikasi Oleh')
                                    ->options(User::where('role', 'admin')->pluck('name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->default(fn () => Auth::id())
                                    ->afterStateHydrated(function ($component, $state) {
                                        if (!$state && Auth::check() && Auth::user()->role === 'admin') {
                                            $component->state(Auth::id());
                                        }
                                    })
                                    ->disabled()
                                    ->dehydrated()
                                    ->visible(fn (callable $get) => in_array($get('legal_document_status'), ['verified', 'rejected']))
                                    ->prefixIcon('heroicon-o-user'),

                                FileUpload::make('legal_documents')
                                    ->label('Upload Dokumen Legal')
                                    ->disk('public')
                                    ->directory('wedding-organizer-documents')
                                    ->acceptedFileTypes(['application/pdf', 'image/*'])
                                    ->maxSize(5120)
                                    ->multiple()
                                    ->openable()
                                    ->downloadable()
                                    ->previewable()
                                    ->helperText('Upload Akta Pendirian, NIB, NPWP, dan dokumen pendukung lainnya (Max: 5MB per file)')
                                    ->columnSpan(2),
                            ]),
                        ]), // End Tab Verifikasi Legal

                    ]) // End Tabs
            ]); // Close components
    }

    /**
     * Get the active tab for the form
     * 
     * @return int
     */
    public static function activeTab(): int
    {
        // Return 1 untuk mengaktifkan tab pertama (Informasi Dasar)
        // Bisa diubah sesuai kebutuhan:
        // 1 = Informasi Pengguna & Wilayah
        // 2 = Informasi Dasar Wedding Organizer
        // 3 = Kontak & Lokasi
        // dst...
        return 1;
    }
}
