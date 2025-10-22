<?php

namespace App\Filament\Admin\Resources\EventParticipants\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section as FormSection;
use Filament\Schemas\Schema;
use App\Models\EventHastana;
use Filament\Schemas\Components\Section;

class EventParticipantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Informasi Event')
                    ->icon('heroicon-o-calendar')
                    ->columns(2)
                    ->columnSpan(3)
                    ->schema([
                        Select::make('event_hastana_id')
                            ->label('Event')
                            ->relationship('eventHastana', 'title')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan(2)
                            ->createOptionForm([
                                // Allow creating event from here if needed
                            ]),
                        
                        TextInput::make('registration_code')
                            ->label('Kode Registrasi')
                            ->disabled()
                            ->dehydrated()
                            ->default(fn () => 'REG-' . strtoupper(\Illuminate\Support\Str::random(10)))
                            ->unique(ignoreRecord: true)
                            ->columnSpan(1),
                        
                        Select::make('status')
                            ->label('Status Pendaftaran')
                            ->options([
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                                'cancelled' => 'Cancelled',
                                'attended' => 'Attended',
                            ])
                            ->default('pending')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                // Auto-set confirmed_at saat status berubah ke confirmed
                                if ($state === 'confirmed' && !$get('confirmed_at')) {
                                    $set('confirmed_at', now());
                                }
                                
                                // Auto-set attended_at saat status berubah ke attended
                                if ($state === 'attended') {
                                    if (!$get('confirmed_at')) {
                                        $set('confirmed_at', now());
                                    }
                                    if (!$get('attended_at')) {
                                        $set('attended_at', now());
                                    }
                                }
                                
                                // Reset timestamp jika status kembali ke pending
                                if ($state === 'pending') {
                                    $set('confirmed_at', null);
                                    $set('attended_at', null);
                                }
                                
                                // Reset attended_at jika dari attended ke confirmed
                                if ($state === 'confirmed' && $get('attended_at')) {
                                    $set('attended_at', null);
                                }
                            })
                            ->helperText(function ($get) {
                                $paymentStatus = $get('payment_status');
                                if ($paymentStatus === 'pending') {
                                    return '⚠️ Pembayaran masih pending, konfirmasi setelah dibayar';
                                } elseif ($paymentStatus === 'paid') {
                                    return '✓ Pembayaran sudah lunas, bisa dikonfirmasi';
                                } elseif ($paymentStatus === 'free') {
                                    return '✓ Event gratis, bisa langsung dikonfirmasi';
                                }
                                return null;
                            })
                            ->columnSpan(1),
                    ]),

                Section::make('Data Peserta')
                    ->icon('heroicon-o-user')
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                        
                        TextInput::make('phone')
                            ->label('No. Telepon/WhatsApp')
                            ->tel()
                            ->required()
                            ->maxLength(20)
                            ->columnSpan(1),
                        
                        TextInput::make('company')
                            ->label('Perusahaan/Instansi')
                            ->maxLength(255)
                            ->columnSpan(1),
                        
                        TextInput::make('position')
                            ->label('Jabatan/Posisi')
                            ->maxLength(255)
                            ->columnSpan(1),
                        
                        Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Informasi Pembayaran & Kehadiran')
                    ->icon('heroicon-o-credit-card')
                    ->columns(2)
                    ->columnSpan(1)
                    ->schema([
                        Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                'free' => 'Gratis',
                                'pending' => 'Menunggu Pembayaran',
                                'paid' => 'Sudah Dibayar',
                                'refunded' => 'Refund',
                            ])
                            ->default('free')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                // Auto-update status berdasarkan payment_status
                                if ($state === 'paid') {
                                    // Jika sudah dibayar, otomatis konfirmasi
                                    if ($get('status') === 'pending') {
                                        $set('status', 'confirmed');
                                        $set('confirmed_at', now());
                                    }
                                } elseif ($state === 'pending') {
                                    // Jika pembayaran pending, status tetap pending
                                    if ($get('status') === 'confirmed') {
                                        $set('status', 'pending');
                                        $set('confirmed_at', null);
                                    }
                                } elseif ($state === 'free') {
                                    // Event gratis bisa langsung confirmed
                                    if ($get('status') === 'pending') {
                                        $set('status', 'confirmed');
                                        $set('confirmed_at', now());
                                    }
                                }
                            })
                            ->helperText('Status pembayaran akan mempengaruhi status pendaftaran')
                            ->columnSpan(2),
                        
                        Select::make('payment_method')
                            ->label('Metode Pembayaran')
                            ->options([
                                'bca' => 'Transfer Bank BCA',
                                'mandiri' => 'Transfer Bank Mandiri',
                                'bni' => 'Transfer Bank BNI',
                                'bri' => 'Transfer Bank BRI',
                            ])
                            ->nullable()
                            ->live()
                            ->visible(fn ($get) => !in_array($get('payment_status'), ['free', null]))
                            ->helperText('Metode pembayaran yang digunakan peserta')
                            ->columnSpan(2),
                        
                        FileUpload::make('payment_proof')
                            ->label('Bukti Pembayaran')
                            ->image()
                            ->disk('public')
                            ->directory('payment_proofs')
                            ->visibility('public')
                            ->nullable()
                            ->openable()
                            ->previewable(true)
                            ->live()
                            ->visible(fn ($get) => !in_array($get('payment_status'), ['free', null]))
                            ->imagePreviewHeight('250')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                // Auto-update payment_status ke 'paid' saat upload bukti
                                if ($state && $get('payment_status') === 'pending') {
                                    $set('payment_status', 'paid');
                                }
                            })
                            ->helperText('Upload bukti transfer pembayaran (JPG, PNG - Max 2MB)')
                            ->columnSpan(2),
                        
                        DateTimePicker::make('confirmed_at')
                            ->label('Waktu Konfirmasi')
                            ->displayFormat('d M Y, H:i')
                            ->seconds(false)
                            ->helperText('Diisi otomatis saat status berubah ke confirmed')
                            ->columnSpan(1),
                        
                        DateTimePicker::make('attended_at')
                            ->label('Waktu Kehadiran')
                            ->displayFormat('d M Y, H:i')
                            ->seconds(false)
                            ->helperText('Diisi saat peserta hadir di event')
                            ->columnSpan(1),
                    ]),
            ]);
    }
}
