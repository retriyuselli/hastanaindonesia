<?php

namespace App\Filament\Admin\Resources\Companies\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use App\Enums\ProvinsiEnum;
use App\Models\User;
use Filament\Schemas\Components\Tabs;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make('Company Information')
                    ->tabs([
                        Tabs\Tab::make('Informasi Dasar')
                            ->icon('heroicon-o-building-office')
                            ->schema([
                                Section::make('Informasi Perusahaan')
                                    ->description('Data dasar perusahaan yang terdaftar')
                                    ->schema([
                                        TextInput::make('company_name')
                                            ->label('Nama Perusahaan')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Masukkan nama perusahaan')
                                            ->prefixIcon('heroicon-o-building-office-2')
                                            ->live(onBlur: true)
                                            ->columnSpanFull(),

                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('owner_name')
                                                    ->label('Nama Ketua Umum')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->placeholder('Nama lengkap pemilik perusahaan')
                                                    ->prefixIcon('heroicon-o-user'),

                                                TextInput::make('business_license')
                                                    ->label('Nomor Izin Usaha')
                                                    ->required()
                                                    ->maxLength(100)
                                                    ->placeholder('SIUP/NIB/Izin lainnya')
                                                    ->unique(ignoreRecord: true)
                                                    ->prefixIcon('heroicon-o-document-text')
                                                    ->helperText('Nomor harus unik'),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('email')
                                                    ->label('Email Perusahaan')
                                                    ->email()
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->placeholder('company@example.com')
                                                    ->unique(ignoreRecord: true)
                                                    ->prefixIcon('heroicon-o-envelope')
                                                    ->suffixIcon('heroicon-o-check-circle')
                                                    ->suffixIconColor('success'),

                                                TextInput::make('phone')
                                                    ->label('Telepon')
                                                    ->tel()
                                                    ->required()
                                                    ->maxLength(20)
                                                    ->placeholder('+62 812 3456 7890')
                                                    ->prefixIcon('heroicon-o-phone')
                                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                                            ]),

                                        TextInput::make('website')
                                            ->label('Website')
                                            ->url()
                                            ->placeholder('https://www.company.com')
                                            ->prefixIcon('heroicon-o-globe-alt')
                                            ->helperText('URL website perusahaan')
                                            ->columnSpanFull(),

                                        Textarea::make('description')
                                            ->label('Deskripsi Perusahaan')
                                            ->placeholder('Jelaskan bidang usaha dan kegiatan perusahaan')
                                            ->rows(3)
                                            ->maxLength(1000)
                                            ->columnSpanFull()
                                            ->helperText(fn ($state, $component) => 'Sisa karakter: ' . (1000 - strlen($state ?? ''))),
                                    ]),
                            ]),

                        Tabs\Tab::make('Alamat & Lokasi')
                            ->icon('heroicon-o-map-pin')
                            ->schema([
                                Section::make('Informasi Alamat')
                                    ->description('Alamat lengkap kantor perusahaan')
                                    ->schema([
                                        Textarea::make('address')
                                            ->label('Alamat Lengkap')
                                            ->required()
                                            ->placeholder('Jalan, nomor, RT/RW, kelurahan, kecamatan')
                                            ->rows(2)
                                            ->maxLength(500)
                                            ->columnSpanFull(),

                                        Grid::make(2)
                                            ->schema([
                                                Select::make('province')
                                                    ->label('Provinsi')
                                                    ->required()
                                                    ->options(ProvinsiEnum::toArray())
                                                    ->searchable()
                                                    ->native(false)
                                                    ->placeholder('Pilih Provinsi')
                                                    ->prefixIcon('heroicon-o-map')
                                                    ->live()
                                                    ->afterStateUpdated(function (callable $set) {
                                                        $set('city', null);
                                                    })
                                                    ->helperText('Pilih provinsi terlebih dahulu'),

                                                Select::make('city')
                                                    ->label('Kota/Kabupaten')
                                                    ->required()
                                                    ->options(function (callable $get) {
                                                        $province = $get('province');
                                                        if (!$province) {
                                                            return [];
                                                        }
                                                        $cities = ProvinsiEnum::getKotaKabupaten($province);
                                                        return array_combine($cities, $cities);
                                                    })
                                                    ->searchable()
                                                    ->native(false)
                                                    ->placeholder('Pilih Kota/Kabupaten')
                                                    ->prefixIcon('heroicon-o-building-office')
                                                    ->disabled(fn (callable $get) => !$get('province'))
                                                    ->helperText(fn (callable $get) => 
                                                        $get('province') 
                                                            ? 'Pilih kota/kabupaten' 
                                                            : '⚠️ Pilih provinsi terlebih dahulu'
                                                    ),

                                                TextInput::make('postal_code')
                                                    ->label('Kode Pos')
                                                    ->required()
                                                    ->maxLength(10)
                                                    ->placeholder('12345')
                                                    ->numeric()
                                                    ->minLength(5)
                                                    ->maxLength(5)
                                                    ->prefixIcon('heroicon-o-envelope')
                                                    ->mask('99999'),
                                            ]),
                                    ]),
                            ]),

                        Tabs\Tab::make('Detail Perusahaan')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Section::make('Informasi Tambahan')
                                    ->description('Detail dan logo perusahaan')
                                    ->schema([
                                        FileUpload::make('logo_url')
                                            ->label('Logo Perusahaan')
                                            ->disk('public')
                                            ->directory('company-logos')
                                            ->image()
                                            ->maxSize(2048)
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([
                                                '1:1',
                                                '16:9',
                                                '4:3',
                                            ])
                                            ->imageResizeMode('cover')
                                            ->imageCropAspectRatio('1:1')
                                            ->imageResizeTargetWidth('500')
                                            ->imageResizeTargetHeight('500')
                                            ->helperText('Format: JPG, PNG. Maksimal 2MB. Rekomendasi: 500x500px')
                                            ->columnSpanFull(),

                                        Grid::make(3)
                                            ->schema([
                                                TextInput::make('established_year')
                                                    ->label('Tahun Didirikan')
                                                    ->numeric()
                                                    ->minValue(1900)
                                                    ->maxValue(date('Y'))
                                                    ->placeholder('2020')
                                                    ->prefixIcon('heroicon-o-calendar')
                                                    ->rules(['digits:4']),

                                                TextInput::make('employee_count')
                                                    ->label('Jumlah Karyawan')
                                                    ->numeric()
                                                    ->minValue(1)
                                                    ->placeholder('10')
                                                    ->prefixIcon('heroicon-o-user-group')
                                                    ->suffix('orang'),

                                                Select::make('legal_entity_type')
                                                    ->label('Jenis Badan Usaha')
                                                    ->options([
                                                        'PT' => 'Perseroan Terbatas (PT)',
                                                        'CV' => 'Commanditaire Vennootschap (CV)',
                                                        'Firma' => 'Firma',
                                                        'UD' => 'Usaha Dagang (UD)',
                                                        'PD' => 'Perusahaan Daerah (PD)',
                                                        'Koperasi' => 'Koperasi',
                                                        'Yayasan' => 'Yayasan',
                                                        'Perkumpulan' => 'Perkumpulan',
                                                    ])
                                                    ->placeholder('Pilih jenis badan usaha')
                                                    ->searchable()
                                                    ->native(false)
                                                    ->prefixIcon('heroicon-o-building-library'),
                                            ]),
                                    ]),
                            ]),

                        Tabs\Tab::make('Dokumen Legal')
                            ->icon('heroicon-o-document-check')
                            ->badge(fn (callable $get) => $get('legal_document_status') === 'verified' ? '✓' : null)
                            ->badgeColor(fn (callable $get) => match($get('legal_document_status')) {
                                'verified' => 'success',
                                'rejected' => 'danger',
                                'pending_review' => 'warning',
                                default => 'gray',
                            })
                            ->schema([
                                Section::make('Informasi Legalitas')
                                    ->description('⚠️ Pastikan semua dokumen legal telah lengkap dan valid untuk proses verifikasi. Upload dokumen dalam format PDF atau gambar dengan ukuran maksimal 5MB per file.')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('deed_of_establishment')
                                                    ->label('Nomor Akta Pendirian')
                                                    ->maxLength(100)
                                                    ->placeholder('No. 123/2020')
                                                    ->prefixIcon('heroicon-o-document-text'),

                                                DatePicker::make('deed_date')
                                                    ->label('Tanggal Akta Pendirian')
                                                    ->maxDate(now())
                                                    ->native(false)
                                                    ->displayFormat('d/m/Y')
                                                    ->prefixIcon('heroicon-o-calendar'),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('notary_name')
                                                    ->label('Nama Notaris')
                                                    ->maxLength(255)
                                                    ->placeholder('Dr. John Doe, S.H., M.Kn.')
                                                    ->prefixIcon('heroicon-o-user'),

                                                TextInput::make('notary_license_number')
                                                    ->label('Nomor Izin Notaris')
                                                    ->maxLength(100)
                                                    ->placeholder('123/KEP/2020')
                                                    ->prefixIcon('heroicon-o-identification'),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('nib_number')
                                                    ->label('Nomor NIB')
                                                    ->maxLength(100)
                                                    ->placeholder('1234567890123')
                                                    ->prefixIcon('heroicon-o-finger-print')
                                                    ->helperText('Nomor Induk Berusaha'),

                                                DatePicker::make('nib_issued_date')
                                                    ->label('Tanggal Terbit NIB')
                                                    ->maxDate(now())
                                                    ->native(false)
                                                    ->displayFormat('d/m/Y')
                                                    ->prefixIcon('heroicon-o-calendar'),
                                            ]),

                                        DatePicker::make('nib_valid_until')
                                            ->label('NIB Berlaku Sampai')
                                            ->minDate(now())
                                            ->native(false)
                                            ->displayFormat('d/m/Y')
                                            ->prefixIcon('heroicon-o-calendar')
                                            ->helperText('Tanggal berakhirnya NIB'),

                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('npwp_number')
                                                    ->label('Nomor NPWP')
                                                    ->maxLength(20)
                                                    ->placeholder('12.345.678.9-012.000')
                                                    ->prefixIcon('heroicon-o-calculator')
                                                    ->mask('99.999.999.9-999.999')
                                                    ->helperText('Format: 00.000.000.0-000.000'),

                                                DatePicker::make('npwp_issued_date')
                                                    ->label('Tanggal Terbit NPWP')
                                                    ->maxDate(now())
                                                    ->native(false)
                                                    ->displayFormat('d/m/Y')
                                                    ->prefixIcon('heroicon-o-calendar'),
                                            ]),

                                        TextInput::make('tax_office')
                                            ->label('Kantor Pajak')
                                            ->maxLength(255)
                                            ->placeholder('KPP Pratama Jakarta Selatan')
                                            ->prefixIcon('heroicon-o-building-office')
                                            ->columnSpanFull(),

                                        FileUpload::make('legal_documents')
                                            ->label('Dokumen Legal')
                                            ->disk('public')
                                            ->directory('company-documents')
                                            ->multiple()
                                            ->reorderable()
                                            ->appendFiles()
                                            ->acceptedFileTypes(['application/pdf', 'image/*'])
                                            ->maxSize(5120)
                                            ->maxFiles(10)
                                            ->helperText('Upload dokumen legal (Akta, SIUP, NIB, NPWP, dll). Format: PDF/Image. Maks 5MB per file.')
                                            ->columnSpanFull()
                                            ->previewable()
                                            ->downloadable()
                                            ->openable(),
                                    ]),
                            ]),

                        Tabs\Tab::make('Status Verifikasi')
                            ->icon('heroicon-o-shield-check')
                            ->badge(fn (callable $get) => match($get('legal_document_status')) {
                                'verified' => 'Verified',
                                'rejected' => 'Rejected',
                                'pending_review' => 'Pending',
                                'incomplete' => 'Incomplete',
                                default => null,
                            })
                            ->badgeColor(fn (callable $get) => match($get('legal_document_status')) {
                                'verified' => 'success',
                                'rejected' => 'danger',
                                'pending_review' => 'warning',
                                'incomplete' => 'gray',
                                default => 'gray',
                            })
                            ->schema([
                                Section::make('Status Dokumen')
                                    ->description('Verifikasi dokumen legal perusahaan')
                                    ->schema([
                                        Select::make('legal_document_status')
                                            ->label('Status Verifikasi Dokumen')
                                            ->options([
                                                'incomplete' => 'Tidak Lengkap',
                                                'pending_review' => 'Menunggu Review',
                                                'verified' => 'Terverifikasi',
                                                'rejected' => 'Ditolak',
                                            ])
                                            ->default('incomplete')
                                            ->required()
                                            ->live()
                                            ->native(false)
                                            ->prefixIcon('heroicon-o-clipboard-document-check')
                                            ->columnSpanFull()
                                            ->afterStateUpdated(function ($state, callable $set) {
                                                if (in_array($state, ['verified', 'rejected'])) {
                                                    $set('legal_verified_at', now());
                                                    if (Auth::check()) {
                                                        $set('legal_verified_by', Auth::id());
                                                    }
                                                }
                                            })
                                            ->helperText(fn (callable $get) => match($get('legal_document_status')) {
                                                'incomplete' => '❌ Dokumen belum lengkap',
                                                'pending_review' => '⏳ Menunggu proses review',
                                                'verified' => '✅ Dokumen telah diverifikasi',
                                                'rejected' => '🚫 Dokumen ditolak, perlu perbaikan',
                                                default => '',
                                            }),

                                        Textarea::make('legal_document_notes')
                                            ->label('Catatan Verifikasi')
                                            ->placeholder('Catatan reviewer mengenai dokumen legal')
                                            ->rows(3)
                                            ->maxLength(1000)
                                            ->visible(fn (callable $get) => in_array($get('legal_document_status'), ['verified', 'rejected']))
                                            ->columnSpanFull()
                                            ->helperText('Berikan catatan untuk proses verifikasi'),

                                        Grid::make(2)
                                            ->schema([
                                                DateTimePicker::make('legal_verified_at')
                                                    ->label('Tanggal Verifikasi')
                                                    ->visible(fn (callable $get) => in_array($get('legal_document_status'), ['verified', 'rejected']))
                                                    ->native(false)
                                                    ->displayFormat('d/m/Y H:i')
                                                    ->prefixIcon('heroicon-o-calendar')
                                                    ->disabled()
                                                    ->dehydrated(),

                                                Select::make('legal_verified_by')
                                                    ->label('Diverifikasi Oleh')
                                                    ->visible(fn (callable $get) => in_array($get('legal_document_status'), ['verified', 'rejected']))
                                                    ->options(User::all()->pluck('name', 'id'))
                                                    ->searchable()
                                                    ->native(false)
                                                    ->disabled()
                                                    ->dehydrated()
                                                    ->prefixIcon('heroicon-o-user')
                                                    ->helperText('Admin yang melakukan verifikasi'),
                                            ])
                                            ->visible(fn (callable $get) => in_array($get('legal_document_status'), ['verified', 'rejected'])),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }
}
