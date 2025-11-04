<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - {{ $participant->eventHastana->title }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .ticket-container {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #e3f2fd;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #1976d2;
            margin-bottom: 10px;
        }
        .ticket-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        .ticket-subtitle {
            color: #666;
            font-size: 14px;
        }
        .event-info {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .event-title {
            font-size: 18px;
            font-weight: bold;
            color: #1976d2;
            margin-bottom: 10px;
        }
        .info-grid {
            display: table;
            width: 100%;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            width: 30%;
            font-weight: bold;
            color: #555;
            padding: 8px 0;
            vertical-align: top;
        }
        .info-value {
            display: table-cell;
            color: #333;
            padding: 8px 0;
            vertical-align: top;
        }
        .participant-info {
            border-top: 1px solid #ddd;
            padding-top: 20px;
            margin-top: 20px;
        }
        .qr-section {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .registration-code {
            font-size: 24px;
            font-weight: bold;
            color: #1976d2;
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
            margin: 10px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-confirmed {
            background: #e8f5e8;
            color: #2e7d32;
        }
        .status-pending {
            background: #fff3e0;
            color: #f57c00;
        }
        .important-note {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">HASTANA INDONESIA</div>
            <div class="ticket-title">E-TICKET EVENT</div>
            <div class="ticket-subtitle">Tiket Digital Resmi</div>
        </div>

        <!-- Event Information -->
        <div class="event-info">
            <div class="event-title">{{ $participant->eventHastana->title }}</div>
            
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Tanggal:</div>
                    <div class="info-value">
                        {{ \Carbon\Carbon::parse($participant->eventHastana->start_date)->format('d F Y') }}
                        @if($participant->eventHastana->end_date && $participant->eventHastana->end_date !== $participant->eventHastana->start_date)
                            - {{ \Carbon\Carbon::parse($participant->eventHastana->end_date)->format('d F Y') }}
                        @endif
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Waktu:</div>
                    <div class="info-value">
                        {{ \Carbon\Carbon::parse($participant->eventHastana->start_time)->format('H:i') }}
                        @if($participant->eventHastana->end_time)
                            - {{ \Carbon\Carbon::parse($participant->eventHastana->end_time)->format('H:i') }} WIB
                        @endif
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Lokasi:</div>
                    <div class="info-value">
                        @if($participant->eventHastana->location_type === 'online')
                            Online Event
                        @else
                            {{ $participant->eventHastana->venue ?? $participant->eventHastana->location }}<br>
                            {{ $participant->eventHastana->city }}, {{ $participant->eventHastana->province }}
                        @endif
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Kategori:</div>
                    <div class="info-value">{{ $participant->eventHastana->eventCategory->name ?? 'Event' }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Harga:</div>
                    <div class="info-value">
                        @if($participant->eventHastana->is_free)
                            <strong style="color: #4caf50;">GRATIS</strong>
                        @else
                            Rp {{ number_format($participant->eventHastana->price, 0, ',', '.') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- QR Code Section -->
        <div class="qr-section">
            <div style="font-weight: bold; margin-bottom: 10px;">Kode Registrasi</div>
            <div class="registration-code">{{ $participant->registration_code }}</div>
            <div style="font-size: 12px; color: #666; margin-top: 10px;">
                Tunjukkan kode ini saat check-in
            </div>
        </div>

        <!-- Participant Information -->
        <div class="participant-info">
            <h3 style="margin-bottom: 15px; color: #333;">Informasi Peserta</h3>
            
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Nama:</div>
                    <div class="info-value">{{ $participant->name }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $participant->email }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Telepon:</div>
                    <div class="info-value">{{ $participant->phone }}</div>
                </div>
                
                @if($participant->company)
                <div class="info-row">
                    <div class="info-label">Perusahaan:</div>
                    <div class="info-value">{{ $participant->company }}</div>
                </div>
                @endif
                
                @if($participant->position)
                <div class="info-row">
                    <div class="info-label">Posisi:</div>
                    <div class="info-value">{{ $participant->position }}</div>
                </div>
                @endif
                
                <div class="info-row">
                    <div class="info-label">Status:</div>
                    <div class="info-value">
                        <span class="status-badge status-{{ $participant->status === 'confirmed' ? 'confirmed' : 'pending' }}">
                            {{ $participant->status === 'confirmed' ? 'TERKONFIRMASI' : 'MENUNGGU KONFIRMASI' }}
                        </span>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Tgl Daftar:</div>
                    <div class="info-value">{{ $participant->created_at->format('d F Y H:i') }} WIB</div>
                </div>
            </div>
        </div>

        <!-- Important Notes -->
        <div class="important-note">
            <strong>Penting:</strong>
            <ul style="margin: 5px 0; padding-left: 20px;">
                <li>Harap datang 15 menit sebelum acara dimulai</li>
                <li>Tunjukkan e-ticket ini saat registrasi ulang</li>
                <li>E-ticket ini tidak dapat dipindahtangankan</li>
                @if($participant->eventHastana->location_type === 'online')
                <li>Link meeting akan dikirim via email sebelum acara</li>
                @endif
            </ul>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih telah mendaftar di event HASTANA Indonesia</p>
            <p>
                Untuk informasi lebih lanjut, hubungi: {{ $participant->eventHastana->contact_email ?? 'info@hastanaindonesia.com' }}<br>
                Website: www.hastanaindonesia.com
            </p>
            <p style="margin-top: 15px; font-size: 10px;">
                E-ticket ini dibuat secara otomatis pada {{ now()->format('d F Y H:i') }} WIB
            </p>
        </div>
    </div>
</body>
</html>