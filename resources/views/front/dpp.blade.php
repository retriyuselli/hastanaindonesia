@extends('layouts.app')

@section('title', 'Dewan Pengurus Pusat - HASTANA Indonesia')
@section('description', 'Struktur kepengurusan Dewan Pengurus Pusat (DPP) HASTANA Indonesia — Himpunan Perusahaan Penata Acara Pernikahan Seluruh Indonesia.')

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-r from-gray-900 via-gray-800 to-red-900 py-20 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-4xl mx-auto">
            @if($dpp?->logo_url)
                <img src="{{ asset('storage/' . $dpp->logo_url) }}"
                     alt="{{ $dpp->company_name }}"
                     class="h-20 w-auto object-contain mx-auto mb-6">
            @else
                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                    <i class="fas fa-landmark text-white text-3xl"></i>
                </div>
            @endif
            <h1 class="text-3xl md:text-4xl font-bold mb-3 leading-tight">
                Dewan Pengurus Pusat
            </h1>
            <p class="text-xl font-semibold text-red-300 mb-3">{{ $dpp?->company_name ?? 'HASTANA Indonesia' }}</p>
            <p class="text-base opacity-80 leading-relaxed max-w-2xl mx-auto">
                Himpunan Perusahaan Penata Acara Pernikahan Seluruh Indonesia
            </p>
            @if($dpp?->established_year)
                <p class="mt-3 text-sm opacity-60">Berdiri sejak {{ $dpp->established_year }}</p>
            @endif
        </div>
    </div>
</section>

<!-- Info Singkat -->
@if($dpp)
<section class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-wrap justify-center gap-8 text-sm text-gray-600">
            @if($dpp->email)
            <div class="flex items-center gap-2">
                <i class="fas fa-envelope text-hastana-red"></i>
                <a href="mailto:{{ $dpp->email }}" class="hover:text-hastana-red transition">{{ $dpp->email }}</a>
            </div>
            @endif
            @if($dpp->phone)
            <div class="flex items-center gap-2">
                <i class="fas fa-phone text-hastana-red"></i>
                <span>{{ $dpp->phone }}</span>
            </div>
            @endif
            @if($dpp->website)
            <div class="flex items-center gap-2">
                <i class="fas fa-globe text-hastana-red"></i>
                <a href="{{ $dpp->website }}" target="_blank" class="hover:text-hastana-red transition">{{ $dpp->website }}</a>
            </div>
            @endif
            @if($dpp->city || $dpp->province)
            <div class="flex items-center gap-2">
                <i class="fas fa-map-marker-alt text-hastana-red"></i>
                <span>{{ collect([$dpp->city, $dpp->province])->filter()->implode(', ') }}</span>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Struktur Kepengurusan -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="inline-block bg-red-100 text-hastana-red text-xs font-semibold px-3 py-1 rounded-full mb-3 uppercase tracking-wide">Periode 2024–2028</span>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">Struktur Kepengurusan DPP</h2>
            <p class="text-gray-500 max-w-xl mx-auto text-sm">Pengurus Pusat yang diamanatkan untuk memimpin dan mengembangkan organisasi HASTANA Indonesia</p>
        </div>

        @php
            $leadership = collect([
                ['jabatan' => 'Ketua Umum',       'user' => $dpp?->ownerUser,       'icon' => 'fa-crown',       'color' => 'red'],
                ['jabatan' => 'Sekretaris Umum',  'user' => $dpp?->sekretarisUmum,  'icon' => 'fa-pen-nib',    'color' => 'gray'],
                ['jabatan' => 'Bendahara Umum',   'user' => $dpp?->bendaharaUmum,   'icon' => 'fa-coins',      'color' => 'gray'],
            ])->filter(fn($i) => $i['user'] !== null);

            $bidang = collect([
                ['jabatan' => 'Bid. Organisasi & Keanggotaan', 'user' => $dpp?->bidOrganisasi,   'icon' => 'fa-sitemap'],
                ['jabatan' => 'Bid. Pengembangan & Pelatihan', 'user' => $dpp?->bidPengembangan, 'icon' => 'fa-graduation-cap'],
                ['jabatan' => 'Bid. Humas',                    'user' => $dpp?->bidHumas1,        'icon' => 'fa-bullhorn'],
                ['jabatan' => 'Bid. Humas',                    'user' => $dpp?->bidHumas2,        'icon' => 'fa-bullhorn'],
                ['jabatan' => 'Bid. Sosial',                   'user' => $dpp?->bidSosial,        'icon' => 'fa-hands-helping'],
                ['jabatan' => 'Bid. Bisnis & Kerjasama',       'user' => $dpp?->bidBisnis,        'icon' => 'fa-handshake'],
                ['jabatan' => 'Bid. Hukum & Advokasi',         'user' => $dpp?->bidHukum,         'icon' => 'fa-balance-scale'],
            ])->filter(fn($i) => $i['user'] !== null);
        @endphp

        <!-- Pimpinan Inti (Ketua, Sekretaris, Bendahara) -->
        @if($leadership->count())
        <div class="flex flex-wrap justify-center gap-6 mb-10">
            @foreach($leadership as $item)
                <div class="bg-white rounded-2xl shadow-md p-6 text-center w-64 hover:shadow-lg transition group border border-gray-100">
                    <!-- Avatar -->
                    <div class="w-20 h-20 rounded-full mx-auto mb-4 flex items-center justify-center text-2xl font-bold
                        {{ $item['color'] === 'red' ? 'bg-gradient-to-br from-hastana-red to-red-700 text-white ring-4 ring-red-100' : 'bg-gradient-to-br from-gray-700 to-gray-900 text-white ring-4 ring-gray-100' }}
                        group-hover:scale-105 transition-transform">
                        @if($item['user']->avatar)
                            <img src="{{ Storage::url($item['user']->avatar) }}" class="w-full h-full object-cover rounded-full" alt="{{ $item['user']->name }}">
                        @else
                            {{ strtoupper(substr($item['user']->name, 0, 1)) }}
                        @endif
                    </div>
                    <!-- Info -->
                    <div class="mb-2">
                        <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full
                            {{ $item['color'] === 'red' ? 'bg-red-100 text-hastana-red' : 'bg-gray-100 text-gray-600' }}">
                            <i class="fas {{ $item['icon'] }} text-xs"></i>
                            {{ $item['jabatan'] }}
                        </span>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base leading-tight">{{ $item['user']->name }}</h3>
                    @if($item['user']->company_name ?? false)
                        <p class="text-xs text-gray-400 mt-1">{{ $item['user']->company_name }}</p>
                    @endif
                </div>
            @endforeach
        </div>
        @endif

        <!-- Divider -->
        <div class="flex items-center gap-4 mb-10">
            <div class="flex-1 h-px bg-gray-200"></div>
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest px-4">Bidang-Bidang</span>
            <div class="flex-1 h-px bg-gray-200"></div>
        </div>

        <!-- Bidang-Bidang -->
        @if($bidang->count())
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
            @foreach($bidang as $item)
                <div class="bg-white rounded-xl shadow-sm p-5 text-center hover:shadow-md transition group border border-gray-100">
                    <div class="w-14 h-14 rounded-full mx-auto mb-3 flex items-center justify-center text-lg font-bold
                        bg-gradient-to-br from-gray-700 to-gray-900 text-white ring-2 ring-gray-100
                        group-hover:scale-105 transition-transform">
                        @if($item['user']->avatar)
                            <img src="{{ Storage::url($item['user']->avatar) }}" class="w-full h-full object-cover rounded-full" alt="{{ $item['user']->name }}">
                        @else
                            {{ strtoupper(substr($item['user']->name, 0, 1)) }}
                        @endif
                    </div>
                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 mb-2">
                        <i class="fas {{ $item['icon'] }} text-xs"></i>
                    </span>
                    <p class="text-xs text-gray-500 mb-1 leading-tight">{{ $item['jabatan'] }}</p>
                    <h3 class="font-bold text-gray-900 text-sm leading-tight">{{ $item['user']->name }}</h3>
                </div>
            @endforeach
        </div>
        @endif

        @if($leadership->isEmpty() && $bidang->isEmpty())
            <div class="text-center py-16 text-gray-400">
                <i class="fas fa-users text-5xl mb-4 opacity-30"></i>
                <p>Data kepengurusan belum tersedia.</p>
            </div>
        @endif
    </div>
</section>

<!-- Deskripsi Organisasi -->
@if($dpp?->description && $dpp->description !== 'Tidak ada')
<section class="py-14 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Tentang DPP HASTANA</h2>
        <p class="text-gray-600 leading-relaxed">{{ $dpp->description }}</p>
    </div>
</section>
@endif

<!-- CTA -->
<section class="py-14 bg-gray-900 text-white text-center">
    <div class="max-w-3xl mx-auto px-4">
        <h2 class="text-2xl font-bold mb-4">Bergabung dengan HASTANA Indonesia</h2>
        <p class="text-gray-300 mb-8 text-sm">Jadilah bagian dari organisasi Wedding Organizer profesional terbesar di Indonesia.</p>
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
