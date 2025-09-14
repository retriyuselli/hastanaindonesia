<?php

namespace App\Filament\Admin\Resources\Companies\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use App\Models\Region;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                // Company Information
                TextInput::make('company_name')
                    ->label('Nama Perusahaan')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Masukkan nama perusahaan')
                    ->columnSpan(2),

                TextInput::make('owner_name')
                    ->label('Nama Ketua Umum')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Nama lengkap pemilik perusahaan'),

                TextInput::make('business_license')
                    ->label('Nomor Izin Usaha')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('SIUP/NIB/Izin lainnya')
                    ->unique(ignoreRecord: true),

                TextInput::make('email')
                    ->label('Email Perusahaan')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->placeholder('company@example.com')
                    ->unique(ignoreRecord: true),

                TextInput::make('phone')
                    ->label('Telepon')
                    ->tel()
                    ->required()
                    ->maxLength(20)
                    ->placeholder('+62 812 3456 7890'),

                TextInput::make('website')
                    ->label('Website')
                    ->url()
                    ->placeholder('https://www.company.com')
                    ->columnSpan(2),

                Textarea::make('description')
                    ->label('Deskripsi Perusahaan')
                    ->placeholder('Jelaskan bidang usaha dan kegiatan perusahaan')
                    ->rows(3)
                    ->columnSpan(2),

                // Address Information
                Textarea::make('address')
                    ->label('Alamat Lengkap')
                    ->required()
                    ->placeholder('Jalan, nomor, RT/RW, kelurahan, kecamatan')
                    ->rows(2)
                    ->columnSpan(2),

                TextInput::make('city')
                    ->label('Kota/Kabupaten')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('Jakarta Selatan'),

                TextInput::make('province')
                    ->label('Provinsi')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('DKI Jakarta'),

                TextInput::make('postal_code')
                    ->label('Kode Pos')
                    ->required()
                    ->maxLength(10)
                    ->placeholder('12345')
                    ->numeric(),

                // Company Details
                FileUpload::make('logo_url')
                    ->label('Logo Perusahaan')
                    ->disk('public')
                    ->directory('company-logos')
                    ->image()
                    ->maxSize(2048)
                    ->columnSpan(2),

                TextInput::make('established_year')
                    ->label('Tahun Didirikan')
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue(date('Y'))
                    ->placeholder('2020'),

                TextInput::make('employee_count')
                    ->label('Jumlah Karyawan')
                    ->numeric()
                    ->minValue(1)
                    ->placeholder('10'),

                // Legal Documents
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
                    ->columnSpan(2),

                TextInput::make('deed_of_establishment')
                    ->label('Nomor Akta Pendirian')
                    ->maxLength(100)
                    ->placeholder('No. 123/2020'),

                DatePicker::make('deed_date')
                    ->label('Tanggal Akta Pendirian')
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
                    ->label('Status Verifikasi Dokumen')
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
                    ->label('Catatan Verifikasi')
                    ->placeholder('Catatan reviewer mengenai dokumen legal')
                    ->rows(3)
                    ->visible(fn (callable $get) => in_array($get('legal_document_status'), ['verified', 'rejected']))
                    ->columnSpan(2),

                DateTimePicker::make('legal_verified_at')
                    ->label('Tanggal Verifikasi')
                    ->visible(fn (callable $get) => in_array($get('legal_document_status'), ['verified', 'rejected'])),

                TextInput::make('legal_verified_by')
                    ->label('Diverifikasi Oleh')
                    ->numeric()
                    ->visible(fn (callable $get) => in_array($get('legal_document_status'), ['verified', 'rejected'])),

                FileUpload::make('legal_documents')
                    ->label('Dokumen Legal')
                    ->disk('public')
                    ->directory('company-documents')
                    ->multiple()
                    ->acceptedFileTypes(['application/pdf', 'image/*'])
                    ->maxSize(5120)
                    ->columnSpan(2),
            ]);
    }
}
