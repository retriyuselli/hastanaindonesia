@extends('layouts.app')

@section('title', 'Event HASTANA Indonesia')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-gray-900 to-black text-white py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-3">EVENT HASTANA INDONESIA</h1>
            <p class="text-sm text-gray-300">Temukan berbagai event menarik untuk mengembangkan diri Anda</p>
        </div>
    </div>
</section>

<!-- Filter & Search Section -->
<section class="bg-white shadow-md py-5">
    <div class="container mx-auto px-4">
        <form action="{{ route('events') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-3">
            <!-- Search -->
            <div class="md:col-span-2">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari event..." 
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-hastana-red focus:border-transparent">
            </div>

            <!-- Category Filter -->
            <div class="relative">
                <i class="fas fa-list absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs"></i>
                <select name="category" class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-hastana-red focus:border-transparent appearance-none bg-white">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
            </div>

            <!-- City Filter -->
            <div class="relative">
                <i class="fas fa-map-marker-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs"></i>
                <select name="city" class="w-full pl-9 pr-8 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-hastana-red focus:border-transparent appearance-none bg-white">
                    <option value="">Semua Kota</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                            {{ $city }}
                        </option>
                    @endforeach
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full bg-hastana-red text-white px-5 py-2 text-sm rounded-lg hover:bg-red-700 transition duration-200">
                    <i class="fas fa-search mr-1.5 text-xs"></i> Cari
                </button>
            </div>
        </form>

        <!-- Quick Filters -->
        <div class="flex flex-wrap gap-2 mt-3">
            <a href="{{ route('events') }}" 
               class="px-3 py-1.5 text-sm rounded-full {{ !request('filter') ? 'bg-hastana-red text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition">
                Semua Event
            </a>
            <a href="{{ route('events', ['filter' => 'free']) }}" 
               class="px-3 py-1.5 text-sm rounded-full {{ request('filter') == 'free' ? 'bg-hastana-red text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition">
                <i class="fas fa-gift mr-1 text-xs"></i> Gratis
            </a>
            <a href="{{ route('events', ['filter' => 'featured']) }}" 
               class="px-3 py-1.5 text-sm rounded-full {{ request('filter') == 'featured' ? 'bg-hastana-red text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition">
                <i class="fas fa-star mr-1 text-xs"></i> Featured
            </a>
            <a href="{{ route('events', ['filter' => 'trending']) }}" 
               class="px-3 py-1.5 text-sm rounded-full {{ request('filter') == 'trending' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition">
                <i class="fas fa-fire mr-1 text-xs"></i> Trending
            </a>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-10 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Events List -->
            <div class="lg:w-3/4">
                <!-- Sort Options -->
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-xl font-bold text-gray-800">
                        {{ $events->total() }} Event Ditemukan
                    </h2>
                    <form action="{{ route('events') }}" method="GET" class="flex gap-2">
                        @foreach(request()->except(['sort_by', 'sort_order']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <select name="sort_by" onchange="this.form.submit()" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-hastana-red">
                            <option value="start_date" {{ request('sort_by') == 'start_date' ? 'selected' : '' }}>Tanggal</option>
                            <option value="popular" {{ request('sort_by') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                            <option value="price_low" {{ request('sort_by') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_high" {{ request('sort_by') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                        </select>
                    </form>
                </div>

                @if($events->count() > 0)
                    <!-- Events Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-5">
                        @foreach($events as $event)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 flex flex-col h-full">
                                <!-- Event Image -->
                                <div class="relative aspect-[4/5] bg-gray-200">
                                    @if($event->image_url)
                                        <img src="{{ $event->image_url }}" 
                                             alt="{{ $event->title }} - {{ $event->eventCategory->name ?? 'Event' }} di {{ $event->city }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-700 to-gray-900">
                                            <i class="fas fa-calendar-alt text-white text-5xl"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Badges -->
                                    <div class="absolute top-2 left-2 flex gap-1.5">
                                        @if($event->is_featured)
                                            <span class="bg-gray-900 text-white text-xs px-2 py-0.5 rounded-full">
                                                <i class="fas fa-star"></i> Featured
                                            </span>
                                        @endif
                                        @if($event->is_trending)
                                            <span class="bg-hastana-red text-white text-xs px-2 py-0.5 rounded-full">
                                                <i class="fas fa-fire"></i> Trending
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Price Badge -->
                                    <div class="absolute top-2 right-2">
                                        @if($event->is_free)
                                            <span class="bg-hastana-red text-white font-bold text-xs px-2.5 py-1 rounded-full">
                                                <i class="fas fa-gift"></i> Gratis
                                            </span>
                                        @else
                                            <span class="bg-gray-900 text-white font-bold text-xs px-2.5 py-1 rounded-full">
                                                Rp {{ number_format($event->price, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Event Content -->
                                <div class="p-4 flex flex-col grow">
                                    <!-- Category -->
                                    <div class="mb-2">
                                        <span class="text-xs font-semibold text-hastana-red bg-gray-100 px-2 py-0.5 rounded">
                                            {{ $event->eventCategory->name ?? 'Uncategorized' }}
                                        </span>
                                        <span class="text-xs text-gray-500 ml-2">
                                            {{ $event->event_type == 'internal' ? 'Internal' : 'Eksternal' }}
                                        </span>
                                    </div>

                                    <!-- Title -->
                                    <h3 class="text-base font-bold text-gray-800 mb-2 line-clamp-2">
                                        {{ $event->title }}
                                    </h3>

                                    <!-- Short Description -->
                                    <p class="text-gray-600 text-xs mb-3 line-clamp-2">
                                        {{ $event->short_description ?? Str::limit(strip_tags($event->description), 100) }}
                                    </p>

                                    <!-- Event Details -->
                                    <div class="space-y-1.5 mb-4 text-xs text-gray-600 grow">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar text-gray-700 w-4"></i>
                                            <span class="ml-2">{{ $event->start_date->format('d M Y') }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-map-marker-alt text-hastana-red w-4"></i>
                                            <span class="ml-2">{{ $event->city }}</span>
                                        </div>
                                        @if(auth()->check() && auth()->user()->hasRole('super_admin'))
                                        <div class="flex items-center">
                                            <i class="fas fa-users text-gray-700 w-4"></i>
                                            <span class="ml-2">
                                                @if($event->capacity)
                                                    {{ $event->current_participants }} / {{ $event->capacity }} peserta
                                                    <span class="text-xs text-gray-500">({{ number_format($event->capacity_percentage, 0) }}%)</span>
                                                @else
                                                    {{ $event->current_participants }} peserta terdaftar
                                                @endif
                                            </span>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Action Buttons - Always at bottom -->
                                    <div class="flex gap-2 mt-auto">
                                        <a href="{{ route('events.show', $event->slug) }}" 
                                           class="flex-1 text-center bg-hastana-red text-white py-2 text-sm rounded-lg hover:bg-red-700 transition duration-200">
                                            Lihat Detail <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                        </a>
                                        @auth
                                            @if(auth()->user()->isAdmin())
                                                <a href="/admin/event-hastanas/{{ $event->id }}/edit" 
                                                   class="px-4 bg-gray-900 text-white py-2 text-sm rounded-lg hover:bg-black transition duration-200"
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
                        <i class="fas fa-calendar-times text-gray-300 text-5xl mb-3"></i>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">Tidak Ada Event Ditemukan</h3>
                        <p class="text-sm text-gray-500 mb-5">Coba ubah filter pencarian Anda</p>
                        <a href="{{ route('events') }}" class="inline-block bg-hastana-red text-white px-5 py-2.5 text-sm rounded-lg hover:bg-red-700 transition">
                            Reset Filter
                        </a>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/4">
                <!-- Featured Events -->
                @if($featuredEvents->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-5 mb-5">
                        <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-star text-hastana-red mr-2"></i> Event Featured
                        </h3>
                        <div class="space-y-3">
                            @foreach($featuredEvents as $featured)
                                <a href="{{ route('events.show', $featured->slug) }}" class="block group">
                                    <div class="flex gap-2.5">
                                        <div class="w-16 h-16 rounded-lg bg-gray-200 flex-shrink-0 overflow-hidden">
                                            @if($featured->image)
                                                <img src="{{ $featured->image_url }}" 
                                                     alt="{{ $featured->title }}" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-gray-700 to-gray-900 flex items-center justify-center">
                                                    <i class="fas fa-calendar text-white text-xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-xs text-gray-800 group-hover:text-hastana-red line-clamp-2">
                                                {{ $featured->title }}
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <i class="fas fa-calendar text-gray-700"></i>
                                                {{ $featured->start_date->format('d M Y') }}
                                            </p>
                                            <p class="text-xs font-semibold {{ $featured->is_free ? 'text-hastana-red' : 'text-gray-900' }} mt-0.5">
                                                {{ $featured->is_free ? 'GRATIS' : 'Rp ' . number_format($featured->price, 0, ',', '.') }}
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

                <!-- Trending Events -->
                @if($trendingEvents->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-5">
                        <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-fire text-hastana-red mr-2"></i> Event Trending
                        </h3>
                        <div class="space-y-3">
                            @foreach($trendingEvents as $trending)
                                <a href="{{ route('events.show', $trending->slug) }}" class="block group">
                                    <div class="flex gap-2.5">
                                        <div class="w-16 h-16 rounded-lg bg-gray-200 flex-shrink-0 overflow-hidden">
                                            @if($trending->image)
                                                <img src="{{ $trending->image_url }}" 
                                                     alt="{{ $trending->title }}" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center">
                                                    <i class="fas fa-calendar text-white text-xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-xs text-gray-800 group-hover:text-hastana-red line-clamp-2">
                                                {{ $trending->title }}
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <i class="fas fa-calendar text-gray-700"></i>
                                                {{ $trending->start_date->format('d M Y') }}
                                            </p>
                                            @if(auth()->check() && auth()->user()->hasRole('super_admin'))
                                            <p class="text-xs text-gray-500 mt-1">
                                                <i class="fas fa-users text-gray-700"></i>
                                                {{ $trending->current_participants }} peserta terdaftar
                                            </p>
                                            @endif
                                            <p class="text-xs font-semibold {{ $trending->is_free ? 'text-hastana-red' : 'text-gray-900' }} mt-0.5">
                                                {{ $trending->is_free ? 'GRATIS' : 'Rp ' . number_format($trending->price, 0, ',', '.') }}
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
@endsection
