@extends('layouts.app')

@section('title', 'Networking Event - HASTANA Indonesia')
@section('description', 'Bergabung dalam networking event eksklusif HASTANA Indonesia untuk memperluas jaringan bisnis Wedding Organizer.')

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-r from-gray-900 via-gray-800 to-red-900 py-20 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-4xl mx-auto">
            <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                <i class="fas fa-network-wired text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold mb-4 leading-tight">
                Networking <span class="text-red-400">Event</span>
            </h1>
            <p class="text-lg opacity-90 leading-relaxed">
                Perluas jaringan bisnis Anda dan bangun kemitraan strategis bersama Wedding Organizer terbaik se-Indonesia
            </p>
        </div>
    </div>
</section>

<!-- Tentang Networking -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Bangun Koneksi yang Bermakna</h2>
                <p class="text-gray-600 leading-relaxed mb-4">
                    HASTANA Indonesia secara rutin menyelenggarakan networking event yang mempertemukan para Wedding Organizer
                    profesional dari seluruh Indonesia. Event ini dirancang untuk memfasilitasi pertukaran ide, pengalaman,
                    dan peluang bisnis antar anggota.
                </p>
                <p class="text-gray-600 leading-relaxed mb-6">
                    Dari gathering santai hingga forum bisnis formal, setiap event HASTANA adalah kesempatan emas untuk
                    memperluas jaringan dan menemukan mitra bisnis yang tepat.
                </p>
                <a href="{{ route('events') }}" class="inline-flex items-center bg-hastana-red text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                    Lihat Event <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-red-50 rounded-xl p-6 text-center">
                    <div class="text-3xl font-bold text-hastana-red mb-1">10+</div>
                    <div class="text-sm text-gray-600">Event per Tahun</div>
                </div>
                <div class="bg-gray-50 rounded-xl p-6 text-center">
                    <div class="text-3xl font-bold text-gray-900 mb-1">500+</div>
                    <div class="text-sm text-gray-600">Peserta Aktif</div>
                </div>
                <div class="bg-gray-50 rounded-xl p-6 text-center">
                    <div class="text-3xl font-bold text-gray-900 mb-1">34</div>
                    <div class="text-sm text-gray-600">Provinsi Terwakili</div>
                </div>
                <div class="bg-red-50 rounded-xl p-6 text-center">
                    <div class="text-3xl font-bold text-hastana-red mb-1">100+</div>
                    <div class="text-sm text-gray-600">Mitra Vendor</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Jenis Event -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Jenis Networking Event</h2>
            <p class="text-gray-600">Berbagai format event untuk memenuhi kebutuhan networking Anda</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['icon' => 'fa-users', 'title' => 'Annual Congress', 'desc' => 'Kongres tahunan HASTANA yang mempertemukan seluruh anggota dari Indonesia'],
                ['icon' => 'fa-coffee', 'title' => 'Regional Gathering', 'desc' => 'Pertemuan regional untuk memperkuat komunitas WO di setiap wilayah'],
                ['icon' => 'fa-handshake', 'title' => 'Business Forum', 'desc' => 'Forum bisnis eksklusif untuk membahas tren dan peluang industri pernikahan'],
                ['icon' => 'fa-award', 'title' => 'Award Night', 'desc' => 'Malam penghargaan untuk mengapresiasi WO berprestasi di Indonesia'],
            ] as $item)
            <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition text-center">
                <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas {{ $item['icon'] }} text-hastana-red text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">{{ $item['title'] }}</h3>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $item['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 bg-gray-900 text-white text-center">
    <div class="max-w-3xl mx-auto px-4">
        <h2 class="text-2xl font-bold mb-4">Ikuti Event Networking Berikutnya</h2>
        <p class="text-gray-300 mb-8">Jangan lewatkan kesempatan bertemu dan berjejaring dengan WO profesional se-Indonesia.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('events') }}" class="bg-hastana-red text-white px-8 py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                <i class="fas fa-calendar mr-2"></i> Lihat Jadwal Event
            </a>
            <a href="{{ route('contact') }}" class="border border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-gray-900 transition">
                <i class="fas fa-envelope mr-2"></i> Hubungi Kami
            </a>
        </div>
    </div>
</section>

@endsection
