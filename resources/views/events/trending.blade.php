@extends('layouts.app')

@section('title', 'Trending Events - HASTANA Indonesia')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-red-600 to-orange-600 text-white py-16 mt-20">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">
                <i class="fas fa-fire mr-3"></i>Trending Events
            </h1>
            <p class="text-lg text-red-100">Event paling populer dan diminati saat ini</p>
        </div>
    </div>
</section>

<!-- Filter & Search Section -->
<section class="bg-white shadow-md py-6 sticky top-0 z-10">
    <div class="container mx-auto px-4">
        <form action="{{ route('events.trending') }}" method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-3">
            <!-- Search -->
            <div class="md:col-span-2">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari trending event..." 
                       class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
            </div>

            <!-- Category Filter -->
            <div>
                <select name="category" class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- City Filter -->
            <div>
                <select name="city" class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <option value="">Semua Kota</option>
                    @php
                        $cities = \App\Models\EventHastana::where('is_trending', true)
                            ->where('status', 'published')
                            ->where('is_active', true)
                            ->distinct()
                            ->pluck('city')
                            ->filter()
                            ->sort();
                    @endphp
                    @foreach($cities as $city)
                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                            {{ $city }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sort -->
            <div>
                <select name="sort" class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Tanggal Terdekat</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full bg-red-600 text-white text-sm px-6 py-2.5 rounded-lg hover:bg-red-700 transition duration-200">
                    <i class="fas fa-search mr-2"></i> Cari
                </button>
            </div>
        </form>

        <!-- Quick Filters -->
        <div class="flex flex-wrap gap-2 mt-4">
            <a href="{{ route('events') }}" 
               class="px-4 py-2 text-sm rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                Semua Event
            </a>
            <a href="{{ route('events', ['filter' => 'free']) }}" 
               class="px-4 py-2 text-sm rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                <i class="fas fa-gift mr-1"></i> Gratis
            </a>
            <a href="{{ route('events', ['filter' => 'featured']) }}" 
               class="px-4 py-2 text-sm rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                <i class="fas fa-star mr-1"></i> Featured
            </a>
            <a href="{{ route('events', ['filter' => 'trending']) }}" 
               class="px-4 py-2 text-sm rounded-full bg-red-600 text-white transition">
                <i class="fas fa-fire mr-1"></i> Trending
            </a>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Events List -->
            <div class="lg:w-3/4">
                <!-- Event Count -->
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-fire text-red-600 mr-2"></i>
                        {{ $events->total() }} Trending Event Tersedia
                    </h2>
                    <p class="text-sm text-gray-600 mt-2">Diurutkan berdasarkan jumlah peserta terbanyak</p>
                </div>

                @if($events->count() > 0)
                    <!-- Events Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        @foreach($events as $index => $event)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                                <!-- Event Image -->
                                <div class="relative h-44 bg-gray-200">
                                @if($event->image)
                                    <img src="{{ Storage::url($event->image) }}" 
                                         alt="{{ $event->title }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-red-500 to-orange-600">
                                        <i class="fas fa-calendar-alt text-white text-6xl"></i>
                                    </div>
                                @endif
                                
                                <!-- Trending Badge with Rank -->
                                <div class="absolute top-3 left-3">
                                    <span class="bg-red-500 text-white px-2.5 py-1 rounded-full text-xs font-semibold">
                                        <i class="fas fa-fire mr-1"></i> #{{ $index + 1 + ($events->currentPage() - 1) * $events->perPage() }}
                                    </span>
                                </div>

                                <!-- Featured Badge (if applicable) -->
                                @if($event->is_featured)
                                    <div class="absolute top-3 left-16">
                                        <span class="bg-yellow-500 text-white px-2.5 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-star"></i> Featured
                                        </span>
                                    </div>
                                @endif

                                <!-- Price Badge -->
                                <div class="absolute top-3 right-3">
                                    @if($event->is_free)
                                        <span class="bg-green-600 text-white px-3 py-1.5 rounded-full text-xs font-bold">
                                            <i class="fas fa-gift mr-1"></i> GRATIS
                                        </span>
                                    @else
                                        <span class="bg-blue-600 text-white px-3 py-1.5 rounded-full text-xs font-bold">
                                            Rp {{ number_format($event->price, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Event Content -->
                            <div class="p-5">
                                <!-- Category & Type -->
                                <div class="flex gap-2 mb-3">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-1 rounded-full">
                                        {{ $event->eventCategory->name ?? 'Umum' }}
                                    </span>
                                    <span class="bg-purple-100 text-purple-800 text-xs px-2.5 py-1 rounded-full">
                                        {{ ucfirst($event->type) }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <h3 class="text-base font-bold text-gray-800 mb-2 line-clamp-2">
                                    {{ $event->title }}
                                </h3>

                                <!-- Short Description -->
                                <p class="text-gray-600 text-xs mb-3 line-clamp-2">
                                    {{ $event->short_description }}
                                </p>

                                <!-- Popularity Indicator -->
                                <div class="bg-red-50 border border-red-200 rounded-lg p-2.5 mb-3">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <span class="text-xs font-semibold text-red-800">
                                            <i class="fas fa-chart-line mr-1"></i> Kepopuleran
                                        </span>
                                        <span class="text-xs font-bold text-red-600">{{ number_format($event->capacity_percentage, 0) }}%</span>
                                    </div>
                                    <div class="w-full bg-red-200 rounded-full h-1.5">
                                        <div class="bg-red-600 h-1.5 rounded-full transition-all duration-300" style="width: {{ $event->capacity_percentage }}%"></div>
                                    </div>
                                </div>

                                <!-- Event Details -->
                                <div class="space-y-2 text-xs text-gray-600 mb-4">
                                    <!-- Date -->
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt w-5 text-red-600"></i>
                                        <span>{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</span>
                                    </div>

                                    <!-- Location -->
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt w-5 text-red-600"></i>
                                        <span>{{ $event->city }}</span>
                                    </div>

                                    <!-- Participants with Hot Badge -->
                                    <div class="flex items-center">
                                        <i class="fas fa-users w-5 text-red-600"></i>
                                        <span class="font-bold text-red-600">{{ $event->current_participants }} / {{ $event->capacity }}</span>
                                        @if($event->capacity_percentage >= 90)
                                            <span class="ml-2 text-xs bg-red-600 text-white px-2 py-0.5 rounded-full font-bold">
                                                SOLD OUT!
                                            </span>
                                        @elseif($event->capacity_percentage >= 70)
                                            <span class="ml-2 text-xs bg-orange-500 text-white px-2 py-0.5 rounded-full">
                                                {{ number_format($event->capacity_percentage, 0) }}%
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Rating -->
                                    @if($event->rating > 0)
                                        <div class="flex items-center">
                                            <i class="fas fa-star w-5 text-yellow-500"></i>
                                            <span>{{ number_format($event->rating, 1) }} ({{ $event->total_reviews }} review)</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    <a href="{{ route('events.show', $event->slug) }}" 
                                       class="flex-1 text-center bg-red-600 text-white py-2 text-sm rounded-lg hover:bg-red-700 transition duration-200">
                                        Lihat Detail <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                    </a>
                                    @auth
                                        @if(auth()->user()->isAdmin())
                                            <a href="/admin/event-hastanas/{{ $event->id }}/edit" 
                                               class="px-4 bg-yellow-500 text-white py-2 text-sm rounded-lg hover:bg-yellow-600 transition duration-200"
                                               title="Edit Event">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $events->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-lg shadow-md p-10 text-center">
                        <i class="fas fa-fire text-gray-300 text-5xl mb-3"></i>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Trending Event</h3>
                        <p class="text-sm text-gray-500 mb-5">Saat ini belum ada event trending yang tersedia. Coba lagi nanti!</p>
                        <a href="{{ route('events') }}" class="inline-block bg-red-600 text-white px-5 py-2.5 text-sm rounded-lg hover:bg-red-700 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Lihat Semua Event
                        </a>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/4">
                <!-- Top 5 Most Popular -->
                @php
                    $topTrendingEvents = \App\Models\EventHastana::where('is_trending', true)
                        ->where('status', 'published')
                        ->where('is_active', true)
                        ->where('start_date', '>=', now())
                        ->orderBy('current_participants', 'desc')
                        ->take(5)
                        ->get();
                @endphp
                @if($topTrendingEvents->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-5 mb-5">
                        <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-fire text-red-500 mr-2"></i> Top 5 Paling Populer
                        </h3>
                        <div class="space-y-3">
                            @foreach($topTrendingEvents as $index => $trending)
                                <a href="{{ route('events.show', $trending->slug) }}" class="block group">
                                    <div class="flex gap-2.5">
                                        <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-orange-500 text-white rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="w-16 h-16 rounded-lg bg-gray-200 flex-shrink-0 overflow-hidden">
                                            @if($trending->image)
                                                <img src="{{ Storage::url($trending->image) }}" 
                                                     alt="{{ $trending->title }}" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center">
                                                    <i class="fas fa-calendar text-white text-xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-xs text-gray-800 group-hover:text-red-600 line-clamp-2">
                                                {{ $trending->title }}
                                            </h4>
                                            <p class="text-xs text-red-600 font-bold mt-1">
                                                <i class="fas fa-users"></i> {{ $trending->current_participants }} peserta
                                            </p>
                                            <p class="text-xs text-gray-500 mt-0.5">
                                                {{ number_format($trending->capacity_percentage, 0) }}% terisi
                                            </p>
                                        </div>
                                    </div>
                                </a>
                                @if(!$loop->last)
                                    <hr class="border-gray-200">
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Fast Selling Events -->
                @php
                    $fastSellingEvents = \App\Models\EventHastana::where('is_trending', true)
                        ->where('status', 'published')
                        ->where('is_active', true)
                        ->where('start_date', '>=', now())
                        ->whereNotNull('max_participants')
                        ->where('max_participants', '>', 0)
                        ->get()
                        ->filter(function($event) {
                            return $event->capacity_percentage >= 70;
                        })
                        ->sortByDesc('capacity_percentage')
                        ->take(5);
                @endphp
                @if($fastSellingEvents->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-5">
                        <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-bolt text-orange-500 mr-2"></i> Cepat Terjual
                        </h3>
                        <div class="space-y-3">
                            @foreach($fastSellingEvents as $fastSelling)
                                <a href="{{ route('events.show', $fastSelling->slug) }}" class="block group">
                                    <div class="flex gap-2.5">
                                        <div class="w-16 h-16 rounded-lg bg-gray-200 flex-shrink-0 overflow-hidden relative">
                                            @if($fastSelling->image)
                                                <img src="{{ Storage::url($fastSelling->image) }}" 
                                                     alt="{{ $fastSelling->title }}" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center">
                                                    <i class="fas fa-calendar text-white text-xl"></i>
                                                </div>
                                            @endif
                                            @if($fastSelling->capacity_percentage >= 90)
                                                <div class="absolute inset-0 bg-red-600 bg-opacity-90 flex items-center justify-center">
                                                    <span class="text-white text-xs font-bold">HAMPIR HABIS!</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-xs text-gray-800 group-hover:text-red-600 line-clamp-2">
                                                {{ $fastSelling->title }}
                                            </h4>
                                            <div class="mt-1">
                                                <div class="flex items-center justify-between mb-1">
                                                    <span class="text-xs text-gray-600">Terisi</span>
                                                    <span class="text-xs font-bold {{ $fastSelling->capacity_percentage >= 90 ? 'text-red-600' : 'text-orange-600' }}">
                                                        {{ number_format($fastSelling->capacity_percentage, 0) }}%
                                                    </span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                    <div class="{{ $fastSelling->capacity_percentage >= 90 ? 'bg-red-600' : 'bg-orange-500' }} h-1.5 rounded-full" 
                                                         style="width: {{ $fastSelling->capacity_percentage }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                @if(!$loop->last)
                                    <hr class="border-gray-200">
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
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
