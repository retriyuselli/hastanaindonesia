@extends('layouts.app')

@section('title', 'Daftar Anggota - HASTANA Indonesia')
@section('description', 'Direktori lengkap anggota HASTANA Indonesia. Temukan wedding organizer profesional di seluruh Indonesia.')

@push('styles')
<style>
    .member-card {
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
        display: flex;
        flex-direction: column;
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        position: relative;
        height: 100%;
        text-decoration: none;
        color: inherit;
        cursor: pointer;
    }
    
    .member-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        border-color: #d1d5db;
        text-decoration: none;
    }
    
    .member-badge {
        position: absolute;
        top: 0.5rem;
        left: 0.5rem;
        z-index: 10;
    }
    
    .search-box {
        transition: all 0.3s ease;
    }
    
    .search-box:focus {
        transform: scale(1.02);
        box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
    }
    
    /* Logo circle */
    .member-logo {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #f3f4f6;
        margin: 0 auto 1rem;
        display: block;
    }
    
    /* Icon badge on logo */
    .logo-badge {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        background: white;
        border-radius: 50%;
        padding: 0.25rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    
    .logo-badge-icon {
        width: 24px;
        height: 24px;
        background: #fbbf24;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        color: white;
    }
    
    /* Card content wrapper */
    .member-card-content {
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    
    /* Card body flex grow */
    .member-card-body {
        flex: 1;
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-r from-red-900 via-red-800 to-blue-800 py-20 text-white mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                    <i class="fas fa-users text-white text-3xl"></i>
                </div>
            </div>
            
            <h1 class="font-poppins text-4xl md:text-6xl font-bold mb-6 leading-tight">
                Daftar <span class="text-yellow-300">Anggota</span>
            </h1>
            
            <p class="text-xl md:text-2xl mb-8 leading-relaxed opacity-90">
                Wedding Organizer Profesional di Seluruh Indonesia
            </p>
            
            <div class="text-sm opacity-75">
                {{ $members->total() }}+ anggota aktif siap melayani impian pernikahan Anda
            </div>
        </div>
    </div>
</section>

<!-- Search & Filter Section -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <form method="GET" action="{{ route('members') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Search -->
                    <div class="md:col-span-1">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Anggota</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Nama wedding organizer atau kota..." 
                               class="search-box w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <!-- Filter by Region -->
                    <div class="md:col-span-1">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Filter Wilayah</label>
                        <div class="relative">
                            <select name="region" 
                                    class="search-box w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none bg-white">
                                <option value="">Semua Wilayah</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}" {{ request('region') == $region->id ? 'selected' : '' }}>
                                        {{ $region->region_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Search Button -->
                    <div class="md:col-span-1">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">&nbsp;</label>
                        <button type="submit" 
                                class="w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <i class="fas fa-search mr-2"></i>Cari
                        </button>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Members Grid -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-xl text-center">
                <div class="text-3xl font-bold">{{ $members->total() }}</div>
                <div class="text-sm opacity-90">Total Anggota</div>
            </div>
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-xl text-center">
                <div class="text-3xl font-bold">{{ $regions->count() }}</div>
                <div class="text-sm opacity-90">Wilayah</div>
            </div>
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-6 rounded-xl text-center">
                <div class="text-3xl font-bold">{{ $members->avg('rating') ? number_format($members->avg('rating'), 1) : '4.8' }}</div>
                <div class="text-sm opacity-90">Rating Rata-rata</div>
            </div>
            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-xl text-center">
                <div class="text-3xl font-bold">{{ number_format($members->sum('completed_events')) }}</div>
                <div class="text-sm opacity-90">Event Sukses</div>
            </div>
        </div>

        <!-- Members Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="members-grid">
            
            @forelse($members as $member)
            <a href="{{ $member->slug ? route('members.show', $member->slug) : '#' }}" class="member-card {{ !$member->slug ? 'opacity-50 cursor-not-allowed' : '' }}">
                @if($member->is_featured)
                <div class="member-badge">
                    <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold flex items-center">
                        <i class="fas fa-tag mr-1"></i> Deals Available
                    </span>
                </div>
                @endif
                
                <div class="member-card-content text-center">
                    <div class="member-card-body">
                        <!-- Logo Circle -->    
                        <div class="relative inline-block mb-3">
                            @if($member->logo)
                                <img src="{{ Storage::url($member->logo) }}" alt="{{ $member->organizer_name }}" class="member-logo">
                            @else
                                <div class="member-logo bg-gray-900 flex items-center justify-center text-white text-2xl font-bold">
                                    {{ strtoupper(substr($member->organizer_name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="logo-badge">
                                <div class="logo-badge-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Name -->
                        <h3 class="font-bold text-base mb-1 text-gray-900">{{ $member->organizer_name }}</h3>
                        
                        <!-- Category -->
                        <p class="text-gray-600 text-xs mb-1">
                            @if($member->specializations && is_array($member->specializations) && count($member->specializations) > 0)
                                {{ $member->specializations[0] }}
                            @else
                                Wedding Organizer
                            @endif
                        </p>
                        
                        <!-- Location -->
                        <p class="text-gray-500 text-xs mb-3">
                            {{ $member->city }}{{ $member->province ? ', ' . substr($member->province, 0, 2) : '' }}
                        </p>
                        
                        <!-- Price Range -->
                        <div class="text-gray-700 text-xs mb-2">
                            @if($member->price_range_min && $member->price_range_max)
                                <span class="font-semibold">
                                    @if($member->price_range_min < 10000000)
                                        $
                                    @elseif($member->price_range_min < 50000000)
                                        $$
                                    @else
                                        $$$
                                    @endif
                                </span>
                            @else
                                <span class="font-semibold">$$</span>
                            @endif
                            <span class="mx-1">|</span>
                            <!-- Rating -->
                            <span class="inline-flex items-center">
                                <i class="fas fa-star text-yellow-400 mr-1 text-xs"></i>
                                <span class="font-semibold">{{ number_format($member->rating ?? 4.5, 1) }}/5</span>
                                <span class="text-gray-500 ml-1">({{ $member->completed_events ?? 0 }} ulasan)</span>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-search text-6xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak ada anggota ditemukan</h3>
                <p class="text-gray-500">Coba ubah filter atau kata kunci pencarian Anda</p>
            </div>
            @endforelse

        </div>

        <!-- Pagination -->
        @if($members->hasPages())
        <div class="flex justify-center mt-12">
            {{ $members->links() }}
        </div>
        @endif

    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-red-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">
            Bergabunglah dengan Komunitas Professional
        </h2>
        <p class="text-xl mb-8 opacity-90">
            Jadilah bagian dari HASTANA Indonesia dan kembangkan bisnis wedding organizer Anda
        </p>
        <a href="{{ route('join') }}" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-bold rounded-full hover:bg-gray-100 transition-all duration-300 shadow-lg hover:shadow-xl">
            <i class="fas fa-user-plus mr-3"></i>
            Daftar Jadi Anggota
        </a>
    </div>
</section>

@endsection
