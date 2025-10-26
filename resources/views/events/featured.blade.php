@extends('layouts.app')

@section('title', 'Featured Events - HASTANA Indonesia')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-yellow-500 to-yellow-700 text-white py-16 mt-20">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">
                <i class="fas fa-star mr-3"></i>Featured Events
            </h1>
            <p class="text-lg text-yellow-100">Event pilihan terbaik dengan kualitas premium untuk Anda</p>
        </div>
    </div>
</section>

<!-- Filter & Search Section -->
<section class="bg-white shadow-md py-6 sticky top-0 z-10">
    <div class="container mx-auto px-4">
        <form action="{{ route('events.featured') }}" method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-3">
            <!-- Search -->
            <div class="md:col-span-2">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari featured event..." 
                       class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>

            <!-- Category Filter -->
            <div>
                <select name="category" class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
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
                <select name="city" class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    <option value="">Semua Kota</option>
                    @php
                        $cities = \App\Models\EventHastana::where('is_featured', true)
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
                <select name="sort" class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                    <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Tanggal Terdekat</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full bg-yellow-600 text-white text-sm px-6 py-2.5 rounded-lg hover:bg-yellow-700 transition duration-200">
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
               class="px-4 py-2 text-sm rounded-full bg-yellow-600 text-white transition">
                <i class="fas fa-star mr-1"></i> Featured
            </a>
            <a href="{{ route('events', ['filter' => 'trending']) }}" 
               class="px-4 py-2 text-sm rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
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
                        <i class="fas fa-star text-yellow-600 mr-2"></i>
                        {{ $events->total() }} Featured Event Tersedia
                    </h2>
                </div>

                @if($events->count() > 0)
                    <!-- Events Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        @foreach($events as $event)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                                <!-- Event Image -->
                                <div class="relative h-44 bg-gray-200">
                                @if($event->image)
                                    <img src="{{ Storage::url($event->image) }}" 
                                         alt="{{ $event->title }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-yellow-500 to-yellow-700">
                                        <i class="fas fa-calendar-alt text-white text-6xl"></i>
                                    </div>
                                @endif
                                
                                <!-- Featured Badge -->
                                <div class="absolute top-3 left-3">
                                    <span class="bg-yellow-500 text-white px-2.5 py-1 rounded-full text-xs font-semibold">
                                        <i class="fas fa-star mr-1"></i> FEATURED
                                    </span>
                                </div>

                                <!-- Trending Badge (if applicable) -->
                                @if($event->is_trending)
                                    <div class="absolute top-3 left-20">
                                        <span class="bg-red-500 text-white px-2.5 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-fire"></i> Trending
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
                                <p class="text-gray-600 text-xs mb-4 line-clamp-2">
                                    {{ $event->short_description }}
                                </p>

                                <!-- Event Details -->
                                <div class="space-y-2 text-xs text-gray-600 mb-4">
                                    <!-- Date -->
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt w-5 text-yellow-600"></i>
                                        <span>{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</span>
                                    </div>

                                    <!-- Location -->
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt w-5 text-yellow-600"></i>
                                        <span>{{ $event->city }}</span>
                                    </div>

                                    <!-- Participants -->
                                    <div class="flex items-center">
                                        <i class="fas fa-users w-5 text-yellow-600"></i>
                                        <span>{{ $event->current_participants }} / {{ $event->capacity }} peserta</span>
                                        @if($event->capacity_percentage >= 80)
                                            <span class="ml-2 text-xs bg-orange-100 text-orange-800 px-2 py-1 rounded-full">
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
                                       class="flex-1 text-center bg-yellow-600 text-white py-2 text-sm rounded-lg hover:bg-yellow-700 transition duration-200">
                                        Lihat Detail <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                    </a>
                                    @auth
                                        @if(auth()->user()->isAdmin())
                                            <a href="/admin/event-hastanas/{{ $event->id }}/edit" 
                                               class="px-4 bg-orange-500 text-white py-2 text-sm rounded-lg hover:bg-orange-600 transition duration-200"
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
                        <i class="fas fa-star text-gray-300 text-5xl mb-3"></i>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Featured Event</h3>
                        <p class="text-sm text-gray-500 mb-5">Saat ini belum ada event featured yang tersedia. Coba lagi nanti!</p>
                        <a href="{{ route('events') }}" class="inline-block bg-yellow-600 text-white px-5 py-2.5 text-sm rounded-lg hover:bg-yellow-700 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Lihat Semua Event
                        </a>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/4">
                <!-- Top Featured Events -->
                @php
                    $topFeaturedEvents = \App\Models\EventHastana::where('is_featured', true)
                        ->where('status', 'published')
                        ->where('is_active', true)
                        ->where('start_date', '>=', now())
                        ->orderBy('rating', 'desc')
                        ->take(5)
                        ->get();
                @endphp
                @if($topFeaturedEvents->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-5 mb-5">
                        <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-trophy text-yellow-500 mr-2"></i> Top Rating Featured
                        </h3>
                        <div class="space-y-3">
                            @foreach($topFeaturedEvents as $featured)
                                <a href="{{ route('events.show', $featured->slug) }}" class="block group">
                                    <div class="flex gap-2.5">
                                        <div class="w-16 h-16 rounded-lg bg-gray-200 flex-shrink-0 overflow-hidden">
                                            @if($featured->image)
                                                <img src="{{ Storage::url($featured->image) }}" 
                                                     alt="{{ $featured->title }}" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center">
                                                    <i class="fas fa-calendar text-white text-xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-xs text-gray-800 group-hover:text-yellow-600 line-clamp-2">
                                                {{ $featured->title }}
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <i class="fas fa-calendar text-yellow-500"></i>
                                                {{ $featured->start_date->format('d M Y') }}
                                            </p>
                                            @if($featured->rating > 0)
                                                <p class="text-xs font-semibold text-yellow-600 mt-0.5">
                                                    <i class="fas fa-star"></i> {{ number_format($featured->rating, 1) }}
                                                </p>
                                            @else
                                                <p class="text-xs font-semibold {{ $featured->is_free ? 'text-green-600' : 'text-blue-600' }} mt-0.5">
                                                    {{ $featured->is_free ? 'GRATIS' : 'Rp ' . number_format($featured->price, 0, ',', '.') }}
                                                </p>
                                            @endif
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

                <!-- Premium Featured Events (Paid) -->
                @php
                    $premiumFeaturedEvents = \App\Models\EventHastana::where('is_featured', true)
                        ->where('is_free', false)
                        ->where('status', 'published')
                        ->where('is_active', true)
                        ->where('start_date', '>=', now())
                        ->orderBy('price', 'desc')
                        ->take(5)
                        ->get();
                @endphp
                @if($premiumFeaturedEvents->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-5">
                        <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-gem text-purple-500 mr-2"></i> Premium Featured
                        </h3>
                        <div class="space-y-3">
                            @foreach($premiumFeaturedEvents as $premium)
                                <a href="{{ route('events.show', $premium->slug) }}" class="block group">
                                    <div class="flex gap-2.5">
                                        <div class="w-16 h-16 rounded-lg bg-gray-200 flex-shrink-0 overflow-hidden">
                                            @if($premium->image)
                                                <img src="{{ Storage::url($premium->image) }}" 
                                                     alt="{{ $premium->title }}" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                                                    <i class="fas fa-calendar text-white text-xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-xs text-gray-800 group-hover:text-yellow-600 line-clamp-2">
                                                {{ $premium->title }}
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <i class="fas fa-users text-yellow-500"></i>
                                                {{ $premium->current_participants }} peserta
                                            </p>
                                            <p class="text-xs font-semibold text-blue-600 mt-0.5">
                                                Rp {{ number_format($premium->price, 0, ',', '.') }}
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
            </div>
        </div>
    </div>
</section>

<!-- Why Featured Section -->
<section class="bg-gradient-to-br from-yellow-50 to-orange-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-certificate text-yellow-600 mr-2"></i>
                    Kenapa Memilih Featured Event?
                </h2>
                <p class="text-gray-600 text-lg">Event pilihan terbaik dengan standar kualitas tertinggi</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-xl transition">
                    <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-award text-yellow-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Kualitas Premium</h3>
                    <p class="text-gray-600 text-sm">Materi dan pembicara terbaik di bidangnya</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-xl transition">
                    <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-tie text-yellow-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Expert Speaker</h3>
                    <p class="text-gray-600 text-sm">Dipandu oleh praktisi dan ahli berpengalaman</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-xl transition">
                    <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-certificate text-yellow-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Sertifikat Resmi</h3>
                    <p class="text-gray-600 text-sm">Dapatkan sertifikat yang diakui industri</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-xl transition">
                    <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-network-wired text-yellow-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Networking</h3>
                    <p class="text-gray-600 text-sm">Kesempatan bertemu profesional terbaik</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
