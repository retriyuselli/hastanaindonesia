@extends('layouts.app')

@section('title', 'Trending Events - HASTANA Indonesia')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-red-600 to-orange-600 text-white py-16 mt-20">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                <i class="fas fa-fire mr-3"></i>Trending Events
            </h1>
            <p class="text-xl text-red-100">Event paling populer dan diminati saat ini</p>
        </div>
    </div>
</section>

<!-- Filter & Search Section -->
<section class="bg-white shadow-md py-6 sticky top-0 z-10">
    <div class="container mx-auto px-4">
        <form action="{{ route('events.trending') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari trending event..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
            </div>

            <!-- Category Filter -->
            <div>
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition duration-200">
                    <i class="fas fa-search mr-2"></i> Cari
                </button>
            </div>
        </form>

        <!-- Quick Filters -->
        <div class="flex flex-wrap gap-2 mt-4">
            <a href="{{ route('events') }}" 
               class="px-4 py-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                Semua Event
            </a>
            <a href="{{ route('events.free') }}" 
               class="px-4 py-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                <i class="fas fa-gift mr-1"></i> Gratis
            </a>
            <a href="{{ route('events.featured') }}" 
               class="px-4 py-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                <i class="fas fa-star mr-1"></i> Featured
            </a>
            <a href="{{ route('events.trending') }}" 
               class="px-4 py-2 rounded-full bg-red-600 text-white transition">
                <i class="fas fa-fire mr-1"></i> Trending
            </a>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Event Count -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-fire text-red-600 mr-2"></i>
                    {{ $events->total() }} Trending Event Tersedia
                </h2>
                <p class="text-gray-600 mt-2">Diurutkan berdasarkan jumlah peserta terbanyak</p>
            </div>

            @if($events->count() > 0)
                <!-- Events Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    @foreach($events as $index => $event)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border-2 border-red-400">
                            <!-- Event Image -->
                            <div class="relative h-64 bg-gray-200">
                                @if($event->image)
                                    <img src="{{ Storage::url($event->image) }}" 
                                         alt="{{ $event->title }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-red-500 to-orange-600">
                                        <i class="fas fa-calendar-alt text-white text-7xl"></i>
                                    </div>
                                @endif
                                
                                <!-- Trending Badge with Rank -->
                                <div class="absolute top-4 left-4">
                                    <span class="bg-red-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                        <i class="fas fa-fire mr-1"></i> TRENDING #{{ $index + 1 + ($events->currentPage() - 1) * $events->perPage() }}
                                    </span>
                                </div>

                                <!-- Featured Badge (if applicable) -->
                                @if($event->is_featured)
                                    <div class="absolute top-4 right-4">
                                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                            <i class="fas fa-star"></i> Featured
                                        </span>
                                    </div>
                                @endif

                                <!-- Price Badge -->
                                <div class="absolute bottom-4 right-4">
                                    @if($event->is_free)
                                        <span class="bg-green-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                            <i class="fas fa-gift mr-1"></i> GRATIS
                                        </span>
                                    @else
                                        <span class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                            Rp {{ number_format($event->price, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Event Content -->
                            <div class="p-6">
                                <!-- Category & Type -->
                                <div class="flex gap-2 mb-3">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-semibold">
                                        {{ $event->eventCategory->name ?? 'Umum' }}
                                    </span>
                                    <span class="bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full font-semibold">
                                        {{ ucfirst($event->type) }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2">
                                    {{ $event->title }}
                                </h3>

                                <!-- Short Description -->
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ $event->short_description }}
                                </p>

                                <!-- Popularity Indicator -->
                                <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-semibold text-red-800">
                                            <i class="fas fa-chart-line mr-1"></i> Tingkat Kepopuleran
                                        </span>
                                        <span class="text-sm font-bold text-red-600">{{ number_format($event->capacity_percentage, 0) }}%</span>
                                    </div>
                                    <div class="w-full bg-red-200 rounded-full h-2">
                                        <div class="bg-red-600 h-2 rounded-full transition-all duration-300" style="width: {{ $event->capacity_percentage }}%"></div>
                                    </div>
                                </div>

                                <!-- Event Details -->
                                <div class="space-y-2 text-sm text-gray-600 mb-4">
                                    <!-- Date -->
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt w-6 text-red-600"></i>
                                        <span class="font-medium">{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</span>
                                    </div>

                                    <!-- Location -->
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt w-6 text-red-600"></i>
                                        <span>{{ $event->city }}, {{ $event->province }}</span>
                                    </div>

                                    <!-- Participants with Hot Badge -->
                                    <div class="flex items-center">
                                        <i class="fas fa-users w-6 text-red-600"></i>
                                        <span class="font-bold text-red-600">{{ $event->current_participants }} / {{ $event->capacity }} peserta</span>
                                        @if($event->capacity_percentage >= 90)
                                            <span class="ml-2 text-xs bg-red-600 text-white px-2 py-1 rounded-full font-bold animate-pulse">
                                                SOLD OUT SOON!
                                            </span>
                                        @elseif($event->capacity_percentage >= 70)
                                            <span class="ml-2 text-xs bg-orange-500 text-white px-2 py-1 rounded-full font-semibold">
                                                ALMOST FULL
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Rating -->
                                    @if($event->rating > 0)
                                        <div class="flex items-center">
                                            <i class="fas fa-star w-6 text-yellow-500"></i>
                                            <span class="font-medium">{{ number_format($event->rating, 1) }}</span>
                                            <span class="text-gray-500 ml-1">({{ $event->total_reviews }} review)</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Action Button -->
                                <a href="{{ route('events.show', $event->slug) }}" 
                                   class="block w-full text-center bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 shadow-md">
                                    Lihat Detail & Daftar <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $events->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <i class="fas fa-fire text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Trending Event</h3>
                    <p class="text-gray-600 mb-6">Saat ini belum ada event trending yang tersedia. Coba lagi nanti!</p>
                    <a href="{{ route('events') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i> Lihat Semua Event
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Trending Info Section -->
<section class="bg-gradient-to-br from-red-50 to-orange-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-trophy text-red-600 mr-2"></i>
                    Kenapa Event Ini Trending?
                </h2>
                <p class="text-gray-600 text-lg">Event dengan peminat terbanyak dan paling banyak dicari</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-xl transition">
                    <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Paling Diminati</h3>
                    <p class="text-gray-600 text-sm">Event dengan pendaftar terbanyak</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-xl transition">
                    <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Terbatas</h3>
                    <p class="text-gray-600 text-sm">Kuota terbatas, daftar sekarang!</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-xl transition">
                    <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-thumbs-up text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Top Rated</h3>
                    <p class="text-gray-600 text-sm">Direkomendasikan banyak peserta</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-xl transition">
                    <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bolt text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Fast Filling</h3>
                    <p class="text-gray-600 text-sm">Cepat terisi, jangan sampai kehabisan</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
