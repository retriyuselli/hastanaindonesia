@extends('layouts.app')

@section('title', 'Konsultasi Bisnis - HASTANA Indonesia')
@section('description', 'Layanan konsultasi bisnis profesional untuk Wedding Organizer yang ingin mengembangkan usahanya bersama HASTANA Indonesia.')

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-r from-gray-900 via-gray-800 to-red-900 py-20 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-4xl mx-auto">
            <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                <i class="fas fa-briefcase text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold mb-4 leading-tight">
                Konsultasi <span class="text-red-400">Bisnis</span>
            </h1>
            <p class="text-lg opacity-90 leading-relaxed">
                Dapatkan panduan strategis dari para ahli untuk mengembangkan bisnis Wedding Organizer Anda ke level berikutnya
            </p>
        </div>
    </div>
</section>

<!-- Layanan Konsultasi -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Area Konsultasi</h2>
            <p class="text-gray-600">Kami membantu Anda dalam berbagai aspek pengembangan bisnis WO</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach([
                ['icon' => 'fa-chart-pie', 'title' => 'Strategi Bisnis', 'desc' => 'Pengembangan visi, misi, dan strategi pertumbuhan jangka panjang untuk bisnis WO Anda.'],
                ['icon' => 'fa-coins', 'title' => 'Manajemen Keuangan', 'desc' => 'Pengelolaan cashflow, penetapan harga, profitabilitas, dan perencanaan keuangan bisnis.'],
                ['icon' => 'fa-bullhorn', 'title' => 'Branding & Marketing', 'desc' => 'Membangun identitas merek yang kuat dan strategi pemasaran yang efektif di era digital.'],
                ['icon' => 'fa-file-contract', 'title' => 'Legalitas Usaha', 'desc' => 'Panduan perizinan, perjanjian kontrak dengan klien dan vendor, serta aspek hukum bisnis WO.'],
                ['icon' => 'fa-sitemap', 'title' => 'Pengembangan Organisasi', 'desc' => 'Membangun struktur tim yang efektif, sistem operasional, dan standar pelayanan.'],
                ['icon' => 'fa-laptop-code', 'title' => 'Transformasi Digital', 'desc' => 'Pemanfaatan teknologi dan media sosial untuk meningkatkan jangkauan dan efisiensi bisnis.'],
            ] as $item)
            <div class="border border-gray-200 rounded-xl p-6 hover:border-hastana-red hover:shadow-md transition group">
                <div class="w-12 h-12 bg-gray-100 group-hover:bg-red-50 rounded-lg flex items-center justify-center mb-4 transition">
                    <i class="fas {{ $item['icon'] }} text-gray-600 group-hover:text-hastana-red text-xl transition"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">{{ $item['title'] }}</h3>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $item['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Proses Konsultasi -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Bagaimana Prosesnya?</h2>
                <div class="space-y-6">
                    @foreach([
                        ['num' => '1', 'title' => 'Konsultasi Awal', 'desc' => 'Sesi perkenalan untuk memahami kondisi bisnis dan kebutuhan spesifik Anda secara mendalam.'],
                        ['num' => '2', 'title' => 'Analisis & Diagnosis', 'desc' => 'Tim konsultan kami menganalisis situasi bisnis Anda dan mengidentifikasi area yang perlu ditingkatkan.'],
                        ['num' => '3', 'title' => 'Rencana Aksi', 'desc' => 'Penyusunan rencana pengembangan yang terstruktur, realistis, dan terukur.'],
                        ['num' => '4', 'title' => 'Pendampingan', 'desc' => 'Kami mendampingi implementasi rencana dan memberikan evaluasi berkala untuk memastikan kemajuan.'],
                    ] as $item)
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-hastana-red text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">
                            {{ $item['num'] }}
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $item['title'] }}</h4>
                            <p class="text-sm text-gray-600 mt-1">{{ $item['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center">
                <i class="fas fa-headset text-hastana-red text-5xl mb-6"></i>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Jadwalkan Sesi Konsultasi</h3>
                <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                    Konsultasi perdana gratis selama 30 menit untuk anggota HASTANA Indonesia
                </p>
                <a href="{{ route('contact') }}" class="block w-full bg-hastana-red text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                    Hubungi Kami Sekarang
                </a>
                <p class="text-xs text-gray-400 mt-3">
                    <i class="fas fa-phone mr-1"></i> +62 811-3130-612
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 bg-gray-900 text-white text-center">
    <div class="max-w-3xl mx-auto px-4">
        <h2 class="text-2xl font-bold mb-4">Kembangkan Bisnis WO Anda Bersama Kami</h2>
        <p class="text-gray-300 mb-8">Tim konsultan kami siap membantu Anda mencapai potensi maksimal bisnis Wedding Organizer.</p>
        <a href="{{ route('contact') }}" class="inline-flex items-center bg-hastana-red text-white px-8 py-3 rounded-lg font-semibold hover:bg-red-700 transition">
            <i class="fas fa-calendar-check mr-2"></i> Jadwalkan Konsultasi
        </a>
    </div>
</section>

@endsection
