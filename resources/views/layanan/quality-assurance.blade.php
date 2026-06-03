@extends('layouts.app')

@section('title', 'Quality Assurance - HASTANA Indonesia')
@section('description', 'Sistem jaminan kualitas HASTANA Indonesia untuk memastikan standar layanan Wedding Organizer yang profesional dan konsisten.')

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-r from-gray-900 via-gray-800 to-red-900 py-20 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-4xl mx-auto">
            <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                <i class="fas fa-shield-alt text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold mb-4 leading-tight">
                Quality <span class="text-red-400">Assurance</span>
            </h1>
            <p class="text-lg opacity-90 leading-relaxed">
                Sistem penjaminan mutu HASTANA Indonesia untuk menjaga standar profesionalisme Wedding Organizer di tingkat nasional
            </p>
        </div>
    </div>
</section>

<!-- Tentang QA -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Komitmen Kami terhadap Kualitas</h2>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Quality Assurance (QA) HASTANA adalah sistem pengawasan dan penjaminan mutu yang diterapkan
                    kepada seluruh anggota. Program ini memastikan bahwa setiap WO yang terdaftar di HASTANA
                    memberikan layanan terbaik dan memenuhi standar yang telah ditetapkan.
                </p>
                <p class="text-gray-600 leading-relaxed mb-6">
                    Dengan sistem QA yang ketat, klien dapat memiliki keyakinan penuh bahwa mereka bekerja sama
                    dengan WO profesional yang terpercaya dan bertanggung jawab.
                </p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-red-50 rounded-xl p-6 text-center">
                    <i class="fas fa-check-double text-hastana-red text-3xl mb-3"></i>
                    <div class="font-bold text-gray-900">Double Check</div>
                    <div class="text-sm text-gray-500 mt-1">Verifikasi berlapis</div>
                </div>
                <div class="bg-gray-50 rounded-xl p-6 text-center">
                    <i class="fas fa-sync-alt text-gray-700 text-3xl mb-3"></i>
                    <div class="font-bold text-gray-900">Evaluasi Berkala</div>
                    <div class="text-sm text-gray-500 mt-1">Review rutin tahunan</div>
                </div>
                <div class="bg-gray-50 rounded-xl p-6 text-center">
                    <i class="fas fa-comments text-gray-700 text-3xl mb-3"></i>
                    <div class="font-bold text-gray-900">Feedback Klien</div>
                    <div class="text-sm text-gray-500 mt-1">Sistem penilaian terbuka</div>
                </div>
                <div class="bg-red-50 rounded-xl p-6 text-center">
                    <i class="fas fa-gavel text-hastana-red text-3xl mb-3"></i>
                    <div class="font-bold text-gray-900">Kode Etik</div>
                    <div class="text-sm text-gray-500 mt-1">Standar etika profesi</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Standar QA -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Standar Quality Assurance</h2>
            <p class="text-gray-600">Kriteria yang wajib dipenuhi seluruh anggota HASTANA Indonesia</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach([
                [
                    'icon' => 'fa-handshake',
                    'title' => 'Integritas & Profesionalisme',
                    'items' => ['Kejujuran dalam penawaran harga dan kontrak', 'Ketepatan waktu dan komitmen terhadap perjanjian', 'Transparansi dalam pengelolaan anggaran klien']
                ],
                [
                    'icon' => 'fa-star',
                    'title' => 'Kualitas Layanan',
                    'items' => ['Standar pelayanan minimum yang harus dipenuhi', 'Penanganan keluhan dan komplain secara profesional', 'Kepuasan klien sebagai prioritas utama']
                ],
                [
                    'icon' => 'fa-graduation-cap',
                    'title' => 'Kompetensi SDM',
                    'items' => ['Kewajiban mengikuti program pelatihan berkala', 'Pembaruan pengetahuan tren industri', 'Sertifikasi kompetensi tim inti']
                ],
                [
                    'icon' => 'fa-file-alt',
                    'title' => 'Administrasi & Legalitas',
                    'items' => ['Kelengkapan dokumen legalitas usaha', 'Penggunaan kontrak kerja yang standar', 'Kepatuhan terhadap regulasi yang berlaku']
                ],
            ] as $item)
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
                        <i class="fas {{ $item['icon'] }} text-hastana-red"></i>
                    </div>
                    <h3 class="font-bold text-gray-900">{{ $item['title'] }}</h3>
                </div>
                <ul class="space-y-2">
                    @foreach($item['items'] as $point)
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <i class="fas fa-check text-hastana-red mt-0.5 text-xs"></i>
                        {{ $point }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 bg-gray-900 text-white text-center">
    <div class="max-w-3xl mx-auto px-4">
        <h2 class="text-2xl font-bold mb-4">Bergabung dengan Standar Terbaik</h2>
        <p class="text-gray-300 mb-8">Jadilah bagian dari ekosistem WO profesional yang menjunjung tinggi kualitas dan integritas.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('layanan.sertifikasi') }}" class="bg-hastana-red text-white px-8 py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                <i class="fas fa-certificate mr-2"></i> Daftar Sertifikasi
            </a>
            <a href="{{ route('contact') }}" class="border border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-gray-900 transition">
                <i class="fas fa-envelope mr-2"></i> Hubungi Kami
            </a>
        </div>
    </div>
</section>

@endsection
