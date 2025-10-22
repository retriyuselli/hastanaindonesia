@extends('layouts.app')

@section('title', 'Featured Events - HASTANA Indonesia')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-yellow-500 to-yellow-700 text-white py-16 mt-20">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                <i class="fas fa-star mr-3"></i>Featured Events
            </h1>
            <p class="text-xl text-yellow-100">Event pilihan terbaik dengan kualitas premium untuk Anda</p>
        </div>
    </div>
</section>

<!-- Filter & Search Section -->
<section class="bg-white shadow-md py-6 sticky top-0 z-10">
    <div class="container mx-auto px-4">
        <form action="{{ route('events.featured') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari featured event..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>

            <!-- Category Filter -->
            <div>
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
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
                <button type="submit" class="w-full bg-yellow-600 text-white px-6 py-2 rounded-lg hover:bg-yellow-700 transition duration-200">
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
               class="px-4 py-2 rounded-full bg-yellow-600 text-white transition">
                <i class="fas fa-star mr-1"></i> Featured
            </a>
            <a href="{{ route('events.trending') }}" 
               class="px-4 py-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
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
                    <i class="fas fa-star text-yellow-600 mr-2"></i>
                    {{ $events->total() }} Featured Event Tersedia
                </h2>
            </div>

            @if($events->count() > 0)
                <!-- Events Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    @foreach($events as $event)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border-2 border-yellow-400">
                            <!-- Event Image -->
                            <div class="relative h-64 bg-gray-200">
                                @if($event->image)
                                    <img src="{{ Storage::url($event->image) }}" 
                                         alt="{{ $event->title }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-yellow-500 to-yellow-700">
                                        <i class="fas fa-calendar-alt text-white text-7xl"></i>
                                    </div>
                                @endif
                                
                                <!-- Featured Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="bg-yellow-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                        <i class="fas fa-star mr-1"></i> FEATURED
                                    </span>
                                </div>

                                <!-- Trending Badge (if applicable) -->
                                @if($event->is_trending)
                                    <div class="absolute top-4 right-4">
                                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                            <i class="fas fa-fire"></i> Trending
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

                                <!-- Event Details -->
                                <div class="space-y-2 text-sm text-gray-600 mb-4">
                                    <!-- Date -->
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt w-6 text-yellow-600"></i>
                                        <span class="font-medium">{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</span>
                                    </div>

                                    <!-- Location -->
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt w-6 text-yellow-600"></i>
                                        <span>{{ $event->city }}, {{ $event->province }}</span>
                                    </div>

                                    <!-- Participants -->
                                    <div class="flex items-center">
                                        <i class="fas fa-users w-6 text-yellow-600"></i>
                                        <span>{{ $event->current_participants }} / {{ $event->capacity }} peserta</span>
                                        @if($event->capacity_percentage >= 80)
                                            <span class="ml-2 text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full font-semibold">
                                                Hampir Penuh!
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
                                   class="block w-full text-center bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 shadow-md">
                                    Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
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
                    <i class="fas fa-star text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Featured Event</h3>
                    <p class="text-gray-600 mb-6">Saat ini belum ada event featured yang tersedia. Coba lagi nanti!</p>
                    <a href="{{ route('events') }}" class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i> Lihat Semua Event
                    </a>
                </div>
            @endif
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
