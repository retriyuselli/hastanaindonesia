<?php

namespace App\Filament\Admin\Resources\EventParticipants\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ViewField;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Section;
use App\Models\EventHastana;

class EventParticipantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make('Participant Management')
                    ->tabs([
                        Tab::make('Informasi Event & Pendaftaran')
                            ->icon('heroicon-o-calendar-days')
                            ->badge(fn ($get) => $get('status') === 'pending' ? 'Pending' : null)
                            ->badgeColor(fn ($get) => $get('status') === 'pending' ? 'warning' : 'success')
                            ->schema([
                                Section::make('Detail Event')
                                    ->description('Pilih event dan lihat detail registrasi')
                                    ->icon('heroicon-o-ticket')
                                    ->collapsible()
                                    ->columns(2)
                                    ->schema([
                                        Select::make('event_hastana_id')
                                            ->label('Event')
                                            ->relationship('eventHastana', 'title')
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->columnSpan(2)
                                            ->live()
                                            ->afterStateUpdated(function ($state, callable $set) {
                                                if ($state) {
                                                    $event = EventHastana::find($state);
                                                    if ($event) {
                                                        // Auto-set payment_status based on event
                                                        if ($event->is_free) {
                                                            $set('payment_status', 'free');
                                                        }
                                                    }
                                                }
                                            })
                                            ->helperText(function ($get) {
                                                $eventId = $get('event_hastana_id');
                                                if ($eventId) {
                                                    $event = EventHastana::find($eventId);
                                                    if ($event) {
                                                        return new \Illuminate\Support\HtmlString(
                                                            '<div class="mt-2 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                                                <div class="flex items-center gap-2 mb-2">
                                                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                    </svg>
                                                                    <span class="font-semibold text-blue-900">Info Event:</span>
                                                                </div>
                                                                <div class="space-y-1 text-sm text-blue-800">
                                                                    <div>📅 <strong>Tanggal:</strong> ' . $event->start_date->format('d M Y') . ($event->end_date->ne($event->start_date) ? ' - ' . $event->end_date->format('d M Y') : '') . '</div>
                                                                    <div>📍 <strong>Lokasi:</strong> ' . $event->location . '</div>
                                                                    <div>💰 <strong>Harga:</strong> ' . ($event->is_free ? 'GRATIS' : 'Rp ' . number_format($event->price, 0, ',', '.')) . '</div>
                                                                    <div>👥 <strong>Kuota:</strong> ' . $event->current_participants . ' / ' . $event->capacity . ' peserta</div>
                                                                </div>
                                                                <div class="mt-3">
                                                                    <a href="' . route('filament.admin.resources.event-hastanas.edit', ['record' => $eventId]) . '" 
                                                                        target="_blank" 
                                                                        class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 font-medium">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                                        </svg>
                                                                        Lihat Detail Event
                                                                    </a>
                                                                </div>
                                                            </div>'
                                                        );
                                                    }
                                                }
                                                return 'Pilih event terlebih dahulu untuk melihat detail';
                                            }),
                                        
                                        TextInput::make('registration_code')
                                            ->label('Kode Registrasi')
                                            ->disabled()
                                            ->dehydrated()
                                            ->default(fn () => 'REG-' . strtoupper(\Illuminate\Support\Str::random(10)))
                                            ->unique(ignoreRecord: true)
                                            ->prefixIcon('heroicon-o-qr-code')
                                            ->helperText('Kode unik untuk identifikasi peserta')
                                            ->columnSpan(1),
                                        
                                        Select::make('status')
                                            ->label('Status Pendaftaran')
                                            ->options([
                                                'pending' => '⏳ Pending - Menunggu Konfirmasi',
                                                'confirmed' => '✅ Confirmed - Sudah Dikonfirmasi',
                                                'cancelled' => '❌ Cancelled - Dibatalkan',
                                                'attended' => '🎉 Attended - Sudah Hadir',
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
                                                return 'Pilih status sesuai kondisi peserta';
                                            })
                                            ->columnSpan(1),
                                    ]),

                                Section::make('Timeline Registrasi')
                                    ->description('Waktu-waktu penting dalam proses registrasi')
                                    ->icon('heroicon-o-clock')
                                    ->collapsible()
                                    ->collapsed()
                                    ->columns(2)
                                    ->schema([
                                        DateTimePicker::make('confirmed_at')
                                            ->label('⏰ Waktu Konfirmasi')
                                            ->displayFormat('d M Y, H:i')
                                            ->seconds(false)
                                            ->disabled()
                                            ->dehydrated()
                                            ->helperText('Diisi otomatis saat status berubah ke "Confirmed"')
                                            ->columnSpan(1),
                                        
                                        DateTimePicker::make('attended_at')
                                            ->label('🎯 Waktu Kehadiran')
                                            ->displayFormat('d M Y, H:i')
                                            ->seconds(false)
                                            ->helperText('Diisi otomatis saat status "Attended" atau bisa manual')
                                            ->columnSpan(1),
                                    ]),
                            ]),

                        Tab::make('Data Peserta')
                            ->icon('heroicon-o-user-circle')
                            ->badge(fn ($get) => $get('name') ? null : 'Required')
                            ->badgeColor('danger')
                            ->schema([
                                Section::make('Informasi Pribadi')
                                    ->description('Data lengkap peserta event')
                                    ->icon('heroicon-o-identification')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Nama Lengkap')
                                            ->required()
                                            ->maxLength(255)
                                            ->prefixIcon('heroicon-o-user')
                                            ->placeholder('Masukkan nama lengkap peserta')
                                            ->columnSpan(2),
                                        
                                        TextInput::make('email')
                                            ->label('Email')
                                            ->email()
                                            ->required()
                                            ->maxLength(255)
                                            ->prefixIcon('heroicon-o-envelope')
                                            ->placeholder('email@example.com')
                                            ->helperText('Email akan digunakan untuk mengirim e-ticket dan notifikasi')
                                            ->columnSpan(1),
                                        
                                        TextInput::make('phone')
                                            ->label('No. Telepon/WhatsApp')
                                            ->tel()
                                            ->required()
                                            ->maxLength(20)
                                            ->prefixIcon('heroicon-o-phone')
                                            ->placeholder('08xxxxxxxxxx')
                                            ->helperText('Nomor yang bisa dihubungi via WhatsApp')
                                            ->columnSpan(1),
                                    ]),

                                Section::make('Informasi Profesional')
                                    ->description('Data pekerjaan dan organisasi (opsional)')
                                    ->icon('heroicon-o-briefcase')
                                    ->collapsible()
                                    ->collapsed()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('company')
                                            ->label('Perusahaan/Instansi')
                                            ->maxLength(255)
                                            ->prefixIcon('heroicon-o-building-office')
                                            ->placeholder('Nama perusahaan atau instansi')
                                            ->columnSpan(1),
                                        
                                        TextInput::make('position')
                                            ->label('Jabatan/Posisi')
                                            ->maxLength(255)
                                            ->prefixIcon('heroicon-o-user-circle')
                                            ->placeholder('Jabatan atau posisi saat ini')
                                            ->columnSpan(1),
                                    ]),

                                Section::make('Catatan Tambahan')
                                    ->description('Informasi atau permintaan khusus dari peserta')
                                    ->icon('heroicon-o-chat-bubble-left-right')
                                    ->collapsible()
                                    ->collapsed()
                                    ->schema([
                                        Textarea::make('notes')
                                            ->label('Catatan')
                                            ->rows(4)
                                            ->placeholder('Catatan khusus, permintaan akomodasi, atau informasi penting lainnya...')
                                            ->helperText('Contoh: Alergi makanan, kebutuhan khusus, dll')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Pembayaran & Bukti')
                            ->icon('heroicon-o-banknotes')
                            ->badge(function ($get) {
                                $status = $get('payment_status');
                                if ($status === 'paid') return '✓ Lunas';
                                if ($status === 'pending') return 'Pending';
                                if ($status === 'free') return 'Gratis';
                                return null;
                            })
                            ->badgeColor(function ($get) {
                                return match($get('payment_status')) {
                                    'paid' => 'success',
                                    'pending' => 'warning',
                                    'free' => 'info',
                                    'refunded' => 'danger',
                                    default => 'gray',
                                };
                            })
                            ->schema([
                                Section::make('Status Pembayaran')
                                    ->description('Kelola pembayaran dan bukti transfer')
                                    ->icon('heroicon-o-credit-card')
                                    ->columns(2)
                                    ->schema([
                                        Select::make('payment_status')
                                            ->label('Status Pembayaran')
                                            ->options([
                                                'free' => '🎁 Gratis - Event Gratis',
                                                'pending' => '⏳ Pending - Menunggu Pembayaran',
                                                'paid' => '✅ Paid - Sudah Dibayar',
                                                'refunded' => '↩️ Refunded - Dikembalikan',
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
                                                    if ($get('status') === 'confirmed' && !$get('attended_at')) {
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
                                            ->helperText(function ($get) {
                                                $status = $get('payment_status');
                                                return match($status) {
                                                    'paid' => '✓ Pembayaran lunas, peserta bisa dikonfirmasi',
                                                    'pending' => '⚠️ Menunggu pembayaran dari peserta',
                                                    'free' => '✓ Event gratis, tidak ada pembayaran',
                                                    'refunded' => 'ℹ️ Dana sudah dikembalikan ke peserta',
                                                    default => 'Pilih status pembayaran'
                                                };
                                            })
                                            ->columnSpan(2),
                                        
                                        Select::make('payment_method')
                                            ->label('Metode Pembayaran')
                                            ->options([
                                                'bca' => '🏦 Transfer Bank BCA',
                                                'mandiri' => '🏦 Transfer Bank Mandiri',
                                                'bni' => '🏦 Transfer Bank BNI',
                                                'bri' => '🏦 Transfer Bank BRI',
                                                'gopay' => '💳 GoPay',
                                                'ovo' => '💳 OVO',
                                                'dana' => '💳 DANA',
                                                'cash' => '💵 Tunai',
                                            ])
                                            ->nullable()
                                            ->prefixIcon('heroicon-o-building-library')
                                            ->live()
                                            ->visible(fn ($get) => !in_array($get('payment_status'), ['free', null]))
                                            ->helperText('Pilih metode pembayaran yang digunakan peserta')
                                            ->columnSpan(2),
                                    ]),

                                Section::make('Bukti Pembayaran')
                                    ->description('Upload dan verifikasi bukti transfer')
                                    ->icon('heroicon-o-document-check')
                                    ->visible(fn ($get) => !in_array($get('payment_status'), ['free', null]))
                                    ->schema([
                                        FileUpload::make('payment_proof')
                                            ->label('Upload Bukti Pembayaran')
                                            ->image()
                                            ->disk('public')
                                            ->directory('payment_proofs')
                                            ->visibility('public')
                                            ->nullable()
                                            ->openable()
                                            ->downloadable()
                                            ->previewable(true)
                                            ->imagePreviewHeight('350')
                                            ->maxSize(2048)
                                            ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'])
                                            ->live()
                                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                                // Auto-update payment_status ke 'paid' saat upload bukti
                                                if ($state && $get('payment_status') === 'pending') {
                                                    $set('payment_status', 'paid');
                                                    $set('status', 'confirmed');
                                                    $set('confirmed_at', now());
                                                }
                                            })
                                            ->helperText('Upload bukti transfer (JPG, PNG, PDF - Max 2MB). Status akan otomatis berubah menjadi "Paid".')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Informasi Pembayaran')
                                    ->description('Detail tambahan tentang pembayaran')
                                    ->icon('heroicon-o-information-circle')
                                    ->collapsible()
                                    ->collapsed()
                                    ->visible(fn ($get) => !in_array($get('payment_status'), ['free', null]))
                                    ->schema([
                                        ViewField::make('payment_info')
                                            ->view('filament.forms.components.payment-info')
                                            ->viewData(fn ($get) => [
                                                'eventId' => $get('event_hastana_id'),
                                            ]),
                                    ]),
                            ]),

                        Tab::make('Ringkasan')
                            ->icon('heroicon-o-clipboard-document-check')
                            ->schema([
                                Section::make('Ringkasan Pendaftaran')
                                    ->description('Lihat semua informasi peserta dalam satu tampilan')
                                    ->icon('heroicon-o-document-text')
                                    ->schema([
                                        ViewField::make('summary')
                                            ->view('filament.forms.components.participant-summary')
                                            ->viewData(fn ($get) => [
                                                'name' => $get('name'),
                                                'email' => $get('email'),
                                                'phone' => $get('phone'),
                                                'registrationCode' => $get('registration_code'),
                                                'status' => $get('status'),
                                                'paymentStatus' => $get('payment_status'),
                                                'eventId' => $get('event_hastana_id'),
                                            ]),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }
}
