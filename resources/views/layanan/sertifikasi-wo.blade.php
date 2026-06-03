@extends('layouts.app')

@section('title', 'Sertifikasi WO - HASTANA Indonesia')
@section('description', 'Program sertifikasi resmi bagi Wedding Organizer profesional di bawah naungan HASTANA Indonesia.')

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-r from-gray-900 via-gray-800 to-red-900 py-20 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-4xl mx-auto">
            <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                <i class="fas fa-certificate text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold mb-4 leading-tight">
                Sertifikasi <span class="text-red-400">Wedding Organizer</span>
            </h1>
            <p class="text-lg opacity-90 leading-relaxed">
                Raih pengakuan resmi sebagai Wedding Organizer profesional bersertifikat HASTANA Indonesia
            </p>
        </div>
    </div>
</section>

<!-- Tentang Sertifikasi -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Apa itu Sertifikasi WO HASTANA?</h2>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Sertifikasi WO HASTANA adalah program pengakuan kompetensi resmi yang diberikan kepada Wedding Organizer
                    yang telah memenuhi standar profesionalisme, etika kerja, dan kualitas layanan yang ditetapkan oleh HASTANA Indonesia.
                </p>
                <p class="text-gray-600 leading-relaxed mb-6">
                    Dengan sertifikasi ini, WO Anda mendapatkan legitimasi yang diakui secara nasional, meningkatkan kepercayaan
                    klien, dan membuka akses ke berbagai keuntungan eksklusif anggota HASTANA.
                </p>
                <a href="{{ route('contact') }}" class="inline-flex items-center bg-hastana-red text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                    Daftar Sekarang <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-red-50 rounded-xl p-6 text-center">
                    <i class="fas fa-star text-hastana-red text-3xl mb-3"></i>
                    <div class="font-bold text-gray-900">Diakui Nasional</div>
                    <div class="text-sm text-gray-500 mt-1">Sertifikat resmi organisasi</div>
                </div>
                <div class="bg-gray-50 rounded-xl p-6 text-center">
                    <i class="fas fa-shield-alt text-gray-700 text-3xl mb-3"></i>
                    <div class="font-bold text-gray-900">Terpercaya</div>
                    <div class="text-sm text-gray-500 mt-1">Standar kompetensi ketat</div>
                </div>
                <div class="bg-gray-50 rounded-xl p-6 text-center">
                    <i class="fas fa-users text-gray-700 text-3xl mb-3"></i>
                    <div class="font-bold text-gray-900">Komunitas</div>
                    <div class="text-sm text-gray-500 mt-1">Jaringan WO profesional</div>
                </div>
                <div class="bg-red-50 rounded-xl p-6 text-center">
                    <i class="fas fa-trophy text-hastana-red text-3xl mb-3"></i>
                    <div class="font-bold text-gray-900">Prestise</div>
                    <div class="text-sm text-gray-500 mt-1">Meningkatkan nilai bisnis</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Persyaratan & Proses -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Proses Sertifikasi</h2>
            <p class="text-gray-600">Empat langkah mudah menuju sertifikasi resmi</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach([
                ['step' => '01', 'icon' => 'fa-file-alt', 'title' => 'Pendaftaran', 'desc' => 'Isi formulir pendaftaran dan lengkapi dokumen persyaratan'],
                ['step' => '02', 'icon' => 'fa-search', 'title' => 'Verifikasi', 'desc' => 'Tim HASTANA memverifikasi kelengkapan dan keabsahan dokumen'],
                ['step' => '03', 'icon' => 'fa-clipboard-check', 'title' => 'Penilaian', 'desc' => 'Proses penilaian kompetensi dan portofolio bisnis WO'],
                ['step' => '04', 'icon' => 'fa-certificate', 'title' => 'Sertifikasi', 'desc' => 'Penerbitan sertifikat resmi dan penyerahan kepada anggota'],
            ] as $item)
            <div class="bg-white rounded-xl p-6 shadow-sm text-center relative">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-hastana-red text-white text-xs font-bold px-3 py-1 rounded-full">
                    {{ $item['step'] }}
                </div>
                <i class="fas {{ $item['icon'] }} text-hastana-red text-3xl mb-4 mt-3"></i>
                <h3 class="font-bold text-gray-900 mb-2">{{ $item['title'] }}</h3>
                <p class="text-sm text-gray-600">{{ $item['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 bg-gray-900 text-white text-center">
    <div class="max-w-3xl mx-auto px-4">
        <h2 class="text-2xl font-bold mb-4">Siap Mendapatkan Sertifikasi?</h2>
        <p class="text-gray-300 mb-8">Hubungi kami untuk informasi lebih lanjut mengenai persyaratan dan biaya sertifikasi.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact') }}" class="bg-hastana-red text-white px-8 py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                <i class="fas fa-envelope mr-2"></i> Hubungi Kami
            </a>
            <a href="{{ route('members') }}" class="border border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-gray-900 transition">
                <i class="fas fa-users mr-2"></i> Lihat Anggota
            </a>
        </div>
    </div>
</section>

@endsection
