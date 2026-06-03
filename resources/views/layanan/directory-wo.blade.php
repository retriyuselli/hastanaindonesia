@extends('layouts.app')

@section('title', 'Directory WO - HASTANA Indonesia')
@section('description', 'Direktori lengkap Wedding Organizer bersertifikat HASTANA Indonesia dari seluruh penjuru nusantara.')

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-r from-gray-900 via-gray-800 to-red-900 py-20 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-4xl mx-auto">
            <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                <i class="fas fa-address-book text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold mb-4 leading-tight">
                Directory <span class="text-red-400">Wedding Organizer</span>
            </h1>
            <p class="text-lg opacity-90 leading-relaxed">
                Temukan Wedding Organizer profesional bersertifikat HASTANA yang terpercaya di seluruh Indonesia
            </p>
        </div>
    </div>
</section>

<!-- Tentang Directory -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Direktori Resmi WO Indonesia</h2>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Directory WO HASTANA adalah database komprehensif yang menampilkan profil lengkap seluruh
                    Wedding Organizer anggota HASTANA Indonesia. Setiap WO dalam direktori telah melalui proses
                    verifikasi dan memenuhi standar kualitas HASTANA.
                </p>
                <p class="text-gray-600 leading-relaxed mb-6">
                    Bagi calon pengantin, direktori ini memudahkan pencarian WO terpercaya sesuai lokasi, budget,
                    dan kebutuhan spesifik. Bagi sesama WO, direktori ini menjadi platform kolaborasi dan referral.
                </p>
                <a href="{{ route('members') }}" class="inline-flex items-center bg-hastana-red text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                    Lihat Direktori <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            <div class="space-y-4">
                @foreach([
                    ['icon' => 'fa-check-circle', 'title' => 'Terverifikasi', 'desc' => 'Semua WO dalam direktori telah diverifikasi keanggotaan dan kompetensinya'],
                    ['icon' => 'fa-map-marker-alt', 'title' => 'Seluruh Indonesia', 'desc' => 'Mencakup WO dari Sabang sampai Merauke, dari 34 provinsi'],
                    ['icon' => 'fa-filter', 'title' => 'Filter Lengkap', 'desc' => 'Cari berdasarkan lokasi, spesialisasi, kapasitas, dan kisaran harga'],
                    ['icon' => 'fa-star', 'title' => 'Rating & Ulasan', 'desc' => 'Dilengkapi sistem rating dan ulasan dari klien yang telah menggunakan jasa'],
                ] as $item)
                <div class="flex items-start gap-3">
                    <i class="fas {{ $item['icon'] }} text-hastana-red text-xl mt-0.5"></i>
                    <div>
                        <div class="font-semibold text-gray-900">{{ $item['title'] }}</div>
                        <div class="text-sm text-gray-600">{{ $item['desc'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Kategori Directory -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Kategori Layanan WO</h2>
            <p class="text-gray-600">Temukan WO yang sesuai dengan kebutuhan acara Anda</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach([
                ['icon' => 'fa-rings-wedding', 'title' => 'Pernikahan Adat'],
                ['icon' => 'fa-church', 'title' => 'Pernikahan Gereja'],
                ['icon' => 'fa-mosque', 'title' => 'Pernikahan Islami'],
                ['icon' => 'fa-star-and-crescent', 'title' => 'Pernikahan Modern'],
                ['icon' => 'fa-globe', 'title' => 'Destination Wedding'],
                ['icon' => 'fa-users', 'title' => 'Pernikahan Massal'],
            ] as $item)
            <div class="bg-white rounded-xl p-4 text-center shadow-sm hover:shadow-md transition hover:border-hastana-red border border-transparent cursor-pointer">
                <i class="fas {{ $item['icon'] }} text-hastana-red text-2xl mb-3"></i>
                <div class="text-sm font-medium text-gray-700">{{ $item['title'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 bg-gray-900 text-white text-center">
    <div class="max-w-3xl mx-auto px-4">
        <h2 class="text-2xl font-bold mb-4">Daftarkan WO Anda ke Direktori</h2>
        <p class="text-gray-300 mb-8">Jadilah bagian dari direktori WO terpercaya HASTANA Indonesia dan jangkau lebih banyak klien potensial.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('members') }}" class="bg-hastana-red text-white px-8 py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                <i class="fas fa-address-book mr-2"></i> Lihat Direktori
            </a>
            <a href="{{ route('contact') }}" class="border border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-gray-900 transition">
                <i class="fas fa-plus mr-2"></i> Daftarkan WO Saya
            </a>
        </div>
    </div>
</section>

@endsection
