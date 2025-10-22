@extends('layouts.app')

@section('title', $event->meta_title ?: $event->title . ' - HASTANA Indonesia')
@section('description', $event->meta_description ?: $event->short_description)

@push('styles')
<style>
    .event-detail-hero {
        background: linear-gradient(135deg, #1e40af 0%, #dc2626 100%);
    }
    
    .benefit-item {
        transition: all 0.3s ease;
    }
    
    .benefit-item:hover {
        transform: translateX(10px);
        background-color: #f3f4f6;
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="event-detail-hero py-16 text-white mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                @if($event->badge_type)
                <div class="mb-4">
                    <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-bold">
                        {{ $event->badge_label }}
                    </span>
                </div>
                @endif
                
                <h1 class="font-poppins text-4xl md:text-5xl font-bold mb-6 leading-tight">
                    {{ $event->title }}
                </h1>
                
                <p class="text-xl mb-8 leading-relaxed opacity-90">
                    {{ $event->short_description }}
                </p>
                
                <div class="flex flex-wrap gap-6 mb-8">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-calendar text-white"></i>
                        </div>
                        <div>
                            <div class="text-sm opacity-75">Tanggal</div>
                            <div class="font-semibold">{{ $event->formatted_date }}</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-map-marker-alt text-white"></i>
                        </div>
                        <div>
                            <div class="text-sm opacity-75">Lokasi</div>
                            <div class="font-semibold">{{ $event->city }}</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-tag text-white"></i>
                        </div>
                        <div>
                            <div class="text-sm opacity-75">Harga</div>
                            <div class="font-semibold">{{ $event->formatted_price }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    @if($event->can_register && $event->registration_link)
                    <a href="{{ $event->registration_link }}" target="_blank" 
                       class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-600 font-bold rounded-lg hover:bg-gray-100 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <i class="fas fa-ticket-alt mr-3"></i>
                        Daftar Sekarang
                    </a>
                    @elseif(!$event->can_register)
                    <button disabled 
                       class="inline-flex items-center justify-center px-8 py-4 bg-gray-400 text-white font-bold rounded-lg cursor-not-allowed opacity-75">
                        <i class="fas fa-lock mr-3"></i>
                        Pendaftaran Ditutup
                    </button>
                    @endif
                    
                    <button onclick="window.history.back()" 
                       class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-blue-600 transition-all duration-300">
                        <i class="fas fa-arrow-left mr-3"></i>
                        Kembali
                    </button>
                </div>
            </div>
            
            <div>
                <img src="{{ $event->featured_image_url }}" alt="{{ $event->title }}" 
                     class="rounded-2xl shadow-2xl w-full h-auto">
            </div>
        </div>
    </div>
</section>

<!-- Event Info -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Tentang Event</h2>
                    <div class="prose max-w-none text-gray-600 leading-relaxed">
                        {!! $event->description !!}
                    </div>
                </div>
                
                @if($event->benefits && count($event->benefits) > 0)
                <div class="bg-gradient-to-br from-blue-50 to-red-50 rounded-2xl shadow-lg p-8 mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-gift text-blue-600 mr-3"></i>
                        Benefit yang Anda Dapatkan
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($event->benefits as $benefit)
                        <div class="benefit-item flex items-start p-4 rounded-lg">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-800 font-medium">{{ $benefit }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                @if($event->requirements)
                <div class="bg-yellow-50 rounded-2xl shadow-lg p-8 mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-clipboard-list text-yellow-600 mr-3"></i>
                        Persyaratan
                    </h2>
                    <div class="prose max-w-none text-gray-600">
                        {!! nl2br(e($event->requirements)) !!}
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Event Details Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Detail Event</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <i class="fas fa-tag text-blue-600 mt-1 mr-3"></i>
                            <div>
                                <div class="text-sm text-gray-500">Kategori</div>
                                <div class="font-semibold text-gray-900 capitalize">{{ ucfirst($event->event_type) }}</div>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <i class="fas fa-calendar-alt text-blue-600 mt-1 mr-3"></i>
                            <div>
                                <div class="text-sm text-gray-500">Tanggal</div>
                                <div class="font-semibold text-gray-900">{{ $event->formatted_date }}</div>
                            </div>
                        </div>
                        
                        @if($event->start_time)
                        <div class="flex items-start">
                            <i class="fas fa-clock text-blue-600 mt-1 mr-3"></i>
                            <div>
                                <div class="text-sm text-gray-500">Waktu</div>
                                <div class="font-semibold text-gray-900">
                                    {{ $event->start_time->format('H:i') }} 
                                    @if($event->end_time) - {{ $event->end_time->format('H:i') }} @endif WIB
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-blue-600 mt-1 mr-3"></i>
                            <div>
                                <div class="text-sm text-gray-500">Lokasi</div>
                                <div class="font-semibold text-gray-900">
                                    @if($event->location_type === 'online')
                                        Online Event
                                    @else
                                        {{ $event->venue }}, {{ $event->city }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        @if($event->speaker)
                        <div class="flex items-start">
                            <i class="fas fa-user text-blue-600 mt-1 mr-3"></i>
                            <div>
                                <div class="text-sm text-gray-500">Speaker</div>
                                <div class="font-semibold text-gray-900">{{ $event->speaker }}</div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="flex items-start">
                            <i class="fas fa-money-bill text-blue-600 mt-1 mr-3"></i>
                            <div>
                                <div class="text-sm text-gray-500">Harga</div>
                                <div class="font-semibold text-green-600 text-xl">{{ $event->formatted_price }}</div>
                            </div>
                        </div>
                        
                        @if($event->quota)
                        <div class="flex items-start">
                            <i class="fas fa-users text-blue-600 mt-1 mr-3"></i>
                            <div>
                                <div class="text-sm text-gray-500">Kuota</div>
                                <div class="font-semibold text-gray-900">
                                    {{ $event->remaining_quota }} / {{ $event->quota }} slot tersedia
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="flex items-start">
                            <i class="fas fa-eye text-blue-600 mt-1 mr-3"></i>
                            <div>
                                <div class="text-sm text-gray-500">Dilihat</div>
                                <div class="font-semibold text-gray-900">{{ number_format($event->view_count) }} kali</div>
                            </div>
                        </div>
                    </div>
                    
                    @if($event->can_register && $event->registration_link)
                    <a href="{{ $event->registration_link }}" target="_blank" 
                       class="block mt-6 w-full bg-gradient-to-r from-blue-600 to-red-600 text-white text-center py-3 px-4 rounded-lg hover:from-blue-700 hover:to-red-700 transition-all font-semibold">
                        <i class="fas fa-ticket-alt mr-2"></i>Daftar Sekarang
                    </a>
                    @endif
                    
                    <!-- Share Buttons -->
                    <div class="mt-6 pt-6 border-t">
                        <div class="text-sm text-gray-500 mb-3">Bagikan Event:</div>
                        <div class="flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('events.show', $event->slug)) }}" 
                               target="_blank"
                               class="flex-1 bg-blue-600 text-white text-center py-2 px-3 rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('events.show', $event->slug)) }}&text={{ urlencode($event->title) }}" 
                               target="_blank"
                               class="flex-1 bg-sky-500 text-white text-center py-2 px-3 rounded-lg hover:bg-sky-600 transition-colors">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($event->title . ' - ' . route('events.show', $event->slug)) }}" 
                               target="_blank"
                               class="flex-1 bg-green-600 text-white text-center py-2 px-3 rounded-lg hover:bg-green-700 transition-colors">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Events -->
@if($relatedEvents->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Event Terkait</h2>
            <p class="text-lg text-gray-600">Event lainnya yang mungkin Anda minati</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($relatedEvents as $relatedEvent)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="relative">
                    <img src="{{ $relatedEvent->featured_image_url }}" alt="{{ $relatedEvent->title }}" class="w-full h-48 object-cover">
                    <div class="absolute top-4 right-4">
                        @if($relatedEvent->badge_type)
                        <span class="bg-{{ $relatedEvent->badge_color }}-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                            {{ $relatedEvent->badge_label }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3 text-sm text-gray-500">
                        <span><i class="fas fa-calendar mr-1"></i>{{ $relatedEvent->start_date->format('d M Y') }}</span>
                        <span><i class="fas fa-map-marker-alt mr-1"></i>{{ $relatedEvent->city }}</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $relatedEvent->title }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $relatedEvent->short_description }}</p>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-green-600 font-semibold">{{ $relatedEvent->formatted_price }}</span>
                        <span class="text-sm text-gray-500">{{ $relatedEvent->event_type }}</span>
                    </div>
                    <a href="{{ route('events.show', $relatedEvent->slug) }}" 
                       class="block w-full bg-blue-600 text-white text-center py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
