<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - {{ $participant->eventHastana->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @media print {
            button, .no-print {
                display: none !important;
            }
            body {
                margin: 0;
                padding: 20px;
            }
        }
        @page {
            margin: 1cm;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Print Buttons -->
    <div class="no-print fixed top-4 right-4 flex gap-2 z-50">
        <button onclick="window.print()" 
                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-lg transition-colors">
            <i class="fas fa-print mr-2"></i>
            Print Tiket
        </button>
        <button onclick="window.close()" 
                class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg shadow-lg transition-colors">
            <i class="fas fa-times mr-2"></i>
            Tutup
        </button>
    </div>

    <!-- Ticket Container -->
    <div class="max-w-4xl mx-auto p-8">
        <!-- Main Ticket -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border-4 border-blue-500">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-8 text-center">
                <div class="mb-4">
                    <i class="fas fa-ticket-alt text-6xl opacity-80"></i>
                </div>
                <h1 class="text-4xl font-bold mb-2">E-TICKET</h1>
                <p class="text-xl opacity-90">HASTANA Indonesia</p>
            </div>

            <!-- Event Details -->
            <div class="p-8">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center border-b-2 border-blue-500 pb-4">
                        {{ $participant->eventHastana->title }}
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Date & Time -->
                        <div class="flex items-start gap-4 bg-blue-50 p-4 rounded-lg">
                            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-calendar-alt text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-semibold mb-1">Tanggal & Waktu</p>
                                <p class="text-lg font-bold text-gray-900">
                                    {{ $participant->eventHastana->start_date->format('d F Y') }}
                                </p>
                                <p class="text-gray-700">
                                    {{ substr($participant->eventHastana->start_time, 0, 5) }} - 
                                    {{ substr($participant->eventHastana->end_time, 0, 5) }} WIB
                                </p>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="flex items-start gap-4 bg-green-50 p-4 rounded-lg">
                            <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-semibold mb-1">Lokasi</p>
                                <p class="text-lg font-bold text-gray-900">{{ $participant->eventHastana->venue }}</p>
                                <p class="text-gray-700">{{ $participant->eventHastana->city }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t-2 border-dashed border-gray-300 my-8"></div>

                <!-- Participant Information -->
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Informasi Peserta</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 mb-1">Nama Lengkap</p>
                            <p class="text-lg font-bold text-gray-900">{{ $participant->name }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 mb-1">Email</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $participant->email }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 mb-1">No. Telepon</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $participant->phone }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 mb-1">Status</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                {{ $participant->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                   ($participant->status === 'attended' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($participant->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- QR Code Section -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-8 rounded-2xl text-center">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">QR Code Check-in</h3>
                    <p class="text-gray-700 mb-6">Scan kode ini saat check-in di lokasi event</p>
                    
                    <div class="flex justify-center mb-6">
                        <div id="qrcode" class="bg-white p-6 rounded-xl shadow-lg inline-block"></div>
                    </div>
                    
                    <div class="bg-white rounded-lg p-4 inline-block">
                        <p class="text-sm text-gray-600 mb-2">Kode Registrasi</p>
                        <p class="text-3xl font-mono font-bold text-blue-600">{{ $participant->registration_code }}</p>
                    </div>
                </div>

                <!-- Important Information -->
                <div class="mt-8 bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-r-lg">
                    <div class="flex gap-3">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-xl mt-1"></i>
                        <div>
                            <h4 class="font-bold text-yellow-900 mb-2">Informasi Penting:</h4>
                            <ul class="text-sm text-yellow-800 space-y-1">
                                <li>✓ Tunjukkan QR Code atau kode registrasi saat check-in</li>
                                <li>✓ Datang 30 menit sebelum event dimulai</li>
                                <li>✓ Tiket tidak dapat dipindahtangankan</li>
                                <li>✓ Simpan tiket ini hingga event selesai</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-100 p-6 text-center border-t-2 border-gray-200">
                <p class="text-gray-600 text-sm">
                    Diterbitkan pada: {{ now()->format('d F Y, H:i') }} WIB
                </p>
                <p class="text-gray-500 text-xs mt-2">
                    © {{ date('Y') }} HASTANA Indonesia. All rights reserved.
                </p>
            </div>
        </div>

        <!-- Additional Copy Notice (Print Only) -->
        <div class="mt-4 text-center text-gray-500 text-sm">
            <p>Untuk pertanyaan, hubungi: {{ $participant->eventHastana->contact_email ?? 'info@hastana.com' }}</p>
        </div>
    </div>

    <script>
        // Generate QR Code
        new QRCode(document.getElementById('qrcode'), {
            text: '{{ $participant->registration_code }}',
            width: 250,
            height: 250,
            colorDark: '#1e40af',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.H
        });

        // Auto print when page loads (optional)
        // window.onload = function() {
        //     setTimeout(function() {
        //         window.print();
        //     }, 1000);
        // };
    </script>
</body>
</html>
