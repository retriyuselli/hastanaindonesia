@extends('layouts.app')

@section('title', 'E-Ticket - ' . $participant->eventHastana->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Ticket Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6 text-center">
                <h1 class="text-2xl font-bold mb-2">HASTANA INDONESIA</h1>
                <p class="text-blue-100">E-TICKET EVENT</p>
                <p class="text-sm text-blue-200 mt-2">Tiket Digital Resmi</p>
            </div>

            <!-- Event Information -->
            <div class="p-6">
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h2 class="text-xl font-bold text-blue-800 mb-4">{{ $participant->eventHastana->title }}</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-semibold text-gray-600">Tanggal:</span>
                            <p>{{ \Carbon\Carbon::parse($participant->eventHastana->start_date)->format('d F Y') }}
                            @if($participant->eventHastana->end_date && $participant->eventHastana->end_date !== $participant->eventHastana->start_date)
                                - {{ \Carbon\Carbon::parse($participant->eventHastana->end_date)->format('d F Y') }}
                            @endif</p>
                        </div>
                        
                        <div>
                            <span class="font-semibold text-gray-600">Waktu:</span>
                            <p>{{ \Carbon\Carbon::parse($participant->eventHastana->start_time)->format('H:i') }}
                            @if($participant->eventHastana->end_time)
                                - {{ \Carbon\Carbon::parse($participant->eventHastana->end_time)->format('H:i') }} WIB
                            @endif</p>
                        </div>
                        
                        <div class="md:col-span-2">
                            <span class="font-semibold text-gray-600">Lokasi:</span>
                            <p>
                                @if($participant->eventHastana->location_type === 'online')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-video mr-1"></i> Online Event
                                    </span>
                                @else
                                    {{ $participant->eventHastana->venue ?? $participant->eventHastana->location }}<br>
                                    <span class="text-gray-500">{{ $participant->eventHastana->city }}, {{ $participant->eventHastana->province }}</span>
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <span class="font-semibold text-gray-600">Kategori:</span>
                            <p>{{ $participant->eventHastana->eventCategory->name ?? 'Event' }}</p>
                        </div>
                        
                        <div>
                            <span class="font-semibold text-gray-600">Harga:</span>
                            <p>
                                @if($participant->eventHastana->is_free)
                                    <span class="font-semibold text-green-600">GRATIS</span>
                                @else
                                    <span class="font-semibold">Rp {{ number_format($participant->eventHastana->price, 0, ',', '.') }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Registration Code -->
                <div class="text-center bg-blue-50 rounded-lg p-6 mb-6">
                    <p class="text-sm font-medium text-gray-600 mb-2">Kode Registrasi</p>
                    <div class="text-3xl font-mono font-bold text-blue-800 tracking-wider">
                        {{ $participant->registration_code }}
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Tunjukkan kode ini saat check-in</p>
                </div>

                <!-- Participant Information -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Peserta</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-semibold text-gray-600">Nama:</span>
                            <p>{{ $participant->name }}</p>
                        </div>
                        
                        <div>
                            <span class="font-semibold text-gray-600">Email:</span>
                            <p class="break-all">{{ $participant->email }}</p>
                        </div>
                        
                        <div>
                            <span class="font-semibold text-gray-600">Telepon:</span>
                            <p>{{ $participant->phone }}</p>
                        </div>
                        
                        <div>
                            <span class="font-semibold text-gray-600">Status:</span>
                            <p>
                                @if($participant->status === 'confirmed')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Terkonfirmasi
                                    </span>
                                @elseif($participant->status === 'attended')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-user-check mr-1"></i> Sudah Hadir
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i> Menunggu Konfirmasi
                                    </span>
                                @endif
                            </p>
                        </div>
                        
                        @if($participant->company)
                        <div>
                            <span class="font-semibold text-gray-600">Perusahaan:</span>
                            <p>{{ $participant->company }}</p>
                        </div>
                        @endif
                        
                        @if($participant->position)
                        <div>
                            <span class="font-semibold text-gray-600">Posisi:</span>
                            <p>{{ $participant->position }}</p>
                        </div>
                        @endif
                        
                        <div class="md:col-span-2">
                            <span class="font-semibold text-gray-600">Tanggal Pendaftaran:</span>
                            <p>{{ $participant->created_at->format('d F Y H:i') }} WIB</p>
                        </div>
                    </div>
                </div>

                <!-- Important Notes -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-6">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-2"></i>
                        <div class="text-sm text-yellow-800">
                            <p class="font-semibold mb-2">Penting:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Harap datang 15 menit sebelum acara dimulai</li>
                                <li>Tunjukkan e-ticket ini saat registrasi ulang</li>
                                <li>E-ticket ini tidak dapat dipindahtangankan</li>
                                @if($participant->eventHastana->location_type === 'online')
                                <li>Link meeting akan dikirim via email sebelum acara</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 mt-6">
                    <a href="{{ route('tickets.download', $participant->registration_code) }}" 
                       class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                        <i class="fas fa-download mr-2"></i>
                        Download PDF
                    </a>
                    
                    <button onclick="window.print()" 
                            class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                        <i class="fas fa-print mr-2"></i>
                        Print Ticket
                    </button>
                    
                    <a href="{{ route('events.show', $participant->eventHastana->slug) }}" 
                       class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Event
                    </a>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="text-center mt-6 text-sm text-gray-600">
            <p>Untuk informasi lebih lanjut, hubungi:</p>
            <p class="font-medium">{{ $participant->eventHastana->contact_email ?? 'info@hastanaindonesia.com' }}</p>
            <p class="text-xs mt-2">www.hastanaindonesia.com</p>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        .no-print {
            display: none !important;
        }
        body {
            background: white !important;
        }
        .shadow-lg {
            box-shadow: none !important;
        }
    }
</style>
@endpush
@endsection