@extends('layouts.app')

@section('title', $event->title . ' - Event HASTANA Indonesia')

@section('content')
<!-- Event Hero Section -->
<section class="text-gray-800 py-8 mt-20">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-2 text-sm mb-4">
            <a href="{{ route('home') }}" class="hover:underline">Home</a>
            <span>/</span>
            <a href="{{ route('events') }}" class="hover:underline">Event</a>
            <span>/</span>
            <span class="text-blue-800">{{ $event->title }}</span>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-8 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="lg:w-2/3">
                <!-- Event Header Card -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
                    <!-- Event Image -->
                    <div class="relative h-96 bg-gray-200">
                        @if($event->image)
                            <img src="{{ Storage::url($event->image) }}"
                                 alt="{{ $event->title }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-500 to-blue-700">
                                <i class="fas fa-calendar-alt text-white text-9xl"></i>
                            </div>
                        @endif
                        
                        <!-- Badges -->
                        <div class="absolute top-4 left-4 flex gap-2">
                            @if($event->is_featured)
                                <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="fas fa-star"></i> Featured
                                </span>
                            @endif
                            @if($event->is_trending)
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="fas fa-fire"></i> Trending
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Event Info -->
                    <div class="p-6">
                        <!-- Category & Type -->
                        <div class="flex items-center gap-3 mb-4">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                <i class="fas fa-tag"></i> {{ $event->eventCategory->name ?? 'Uncategorized' }}
                            </span>
                            <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">
                                {{ $event->event_type == 'internal' ? 'Internal' : 'Eksternal' }}
                            </span>
                            <span class="bg-{{ $event->status == 'published' ? 'green' : 'gray' }}-100 text-{{ $event->status == 'published' ? 'green' : 'gray' }}-800 px-3 py-1 rounded-full text-sm">
                                {{ ucfirst($event->status) }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                            {{ $event->title }}
                        </h1>

                        <!-- Short Description -->
                        @if($event->short_description)
                            <p class="text-lg text-gray-600 mb-6">
                                {{ $event->short_description }}
                            </p>
                        @endif

                        <!-- Event Stats -->
                        <div class="flex flex-wrap justify-center gap-6 md:gap-8 p-6 bg-gray-50 rounded-lg">
                            <div class="text-center min-w-[120px]">
                                <i class="fas fa-users text-blue-600 text-2xl mb-2"></i>
                                <div class="text-2xl font-bold text-gray-900">{{ $event->current_participants }}</div>
                                <div class="text-sm text-gray-600">Peserta Terdaftar</div>
                            </div>
                            <div class="text-center min-w-[120px]">
                                <i class="fas fa-ticket-alt text-green-600 text-2xl mb-2"></i>
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ $event->capacity ? $event->remaining_quota : 'Unlimited' }}
                                </div>
                                <div class="text-sm text-gray-600">Sisa Kuota</div>
                            </div>
                            @if($event->rating > 0)
                                <div class="text-center min-w-[120px]">
                                    <i class="fas fa-star text-yellow-500 text-2xl mb-2"></i>
                                    <div class="text-2xl font-bold text-gray-900">{{ number_format($event->rating, 1) }}</div>
                                    <div class="text-sm text-gray-600">Rating</div>
                                </div>
                            @endif
                            <div class="text-center min-w-[120px]">
                                <i class="fas fa-eye text-purple-600 text-2xl mb-2"></i>
                                <div class="text-2xl font-bold text-gray-900">{{ $event->total_reviews }}</div>
                                <div class="text-sm text-gray-600">Reviews</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i> Deskripsi Event
                    </h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! $event->description !!}
                    </div>
                </div>

                <!-- Benefits -->
                @if(count($benefits) > 0)
                    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-gift text-green-600 mr-2"></i> Yang Akan Anda Dapatkan
                        </h2>
                        <ul class="space-y-3">
                            @foreach($benefits as $benefit)
                                <li class="flex items-start gap-3">
                                    <i class="fas fa-check-circle text-green-500 mt-1"></i>
                                    <span class="text-gray-700">{{ trim($benefit) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Requirements -->
                @if(count($requirements) > 0)
                    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-clipboard-list text-orange-600 mr-2"></i> Persyaratan
                        </h2>
                        <ul class="space-y-3">
                            @foreach($requirements as $requirement)
                                <li class="flex items-start gap-3">
                                    <i class="fas fa-exclamation-circle text-orange-500 mt-1"></i>
                                    <span class="text-gray-700">{{ trim($requirement) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Related Events -->
                @if($relatedEvents->count() > 0)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-calendar-alt text-blue-600 mr-2"></i> Event Terkait
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($relatedEvents as $related)
                                <a href="{{ route('events.show', $related->slug) }}" class="block group">
                                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                                        <div class="h-32 bg-gray-200 relative">
                                            @if($related->image)
                                                <img src="{{ Storage::url($related->image) }}" 
                                                     alt="{{ $related->title }}" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                                                    <i class="fas fa-calendar text-white text-3xl"></i>
                                                </div>
                                            @endif
                                            @if($related->is_free)
                                                <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full font-semibold">
                                                    GRATIS
                                                </span>
                                            @endif
                                        </div>
                                        <div class="p-3">
                                            <h3 class="font-semibold text-gray-900 group-hover:text-blue-600 line-clamp-2 mb-2">
                                                {{ $related->title }}
                                            </h3>
                                            <div class="flex items-center text-xs text-gray-600 gap-3">
                                                <span>
                                                    <i class="fas fa-calendar text-blue-500"></i>
                                                    {{ $related->start_date->format('d M Y') }}
                                                </span>
                                                <span>
                                                    <i class="fas fa-map-marker-alt text-red-500"></i>
                                                    {{ $related->city }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/3">
                <!-- Registration Card -->
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-24 mb-6">
                    <!-- Price -->
                    <div class="text-center mb-6">
                        @if($event->is_free)
                            <div class="text-4xl font-bold text-green-600 mb-2">
                                <i class="fas fa-gift"></i> GRATIS
                            </div>
                            <p class="text-gray-600">Event ini gratis untuk semua peserta</p>
                        @else
                            <div class="text-4xl font-bold text-blue-600 mb-2">
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                            </div>
                            <p class="text-gray-600">Per peserta</p>
                        @endif
                    </div>

                    <!-- Capacity Progress -->
                    @if($event->max_participants || $event->quota)
                        <div class="mb-6">
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span>Kapasitas Terisi</span>
                                <span class="font-semibold">{{ number_format($event->capacity_percentage, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                <div class="bg-{{ $event->capacity_percentage >= 90 ? 'red' : ($event->capacity_percentage >= 70 ? 'yellow' : 'green') }}-500 h-full rounded-full transition-all duration-300" 
                                     style="width: {{ min($event->capacity_percentage, 100) }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $event->current_participants }} dari {{ $event->capacity }} peserta terdaftar
                            </p>
                        </div>
                    @endif

                    <!-- Register Button -->
                    @php
                        $isAlmostFull = $event->capacity_percentage >= 90;
                        $canRegister = $event->canRegister();
                        $isRegistered = false;
                        
                        // Check if user already registered
                        if (auth()->check()) {
                            $isRegistered = \App\Models\EventParticipant::where('event_hastana_id', $event->id)
                                ->where('user_id', auth()->id())
                                ->whereIn('status', ['pending', 'confirmed', 'attended'])
                                ->exists();
                        }
                    @endphp

                    @if($isRegistered)
                        <!-- Already Registered -->
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                            <div class="flex items-center gap-3 text-green-800 mb-3">
                                <i class="fas fa-check-circle text-2xl"></i>
                                <div>
                                    <p class="font-bold text-lg">Anda Sudah Terdaftar!</p>
                                    <p class="text-sm">Lihat detail registrasi Anda di Event Saya</p>
                                </div>
                            </div>
                            <a href="{{ route('dashboard') }}" class="block w-full text-center bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition duration-200">
                                <i class="fas fa-tachometer-alt mr-2"></i>
                                Lihat Dashboard Saya
                            </a>
                        </div>
                    @elseif($canRegister)
                        @if($isAlmostFull)
                            <!-- Almost Full Alert -->
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-3 animate-pulse">
                                <div class="flex items-center gap-2 text-red-800 text-sm font-semibold">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span>Hanya {{ $event->remaining_quota }} slot tersisa! Buruan daftar!</span>
                                </div>
                            </div>
                        @endif

                        @auth
                            <!-- User logged in - can register -->
                            <a href="{{ route('events.register', $event->slug) }}" 
                               class="block w-full text-center bg-gradient-to-r from-blue-600 to-blue-700 text-white py-4 rounded-lg font-bold hover:from-blue-700 hover:to-blue-800 transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 mb-4">
                                <i class="fas fa-user-plus mr-2"></i> 
                                @if($event->is_free)
                                    Daftar Gratis Sekarang
                                @else
                                    Daftar & Bayar - Rp {{ number_format($event->price, 0, ',', '.') }}
                                @endif
                            </a>
                        @else
                            <!-- User not logged in - show login prompt -->
                            <div class="mb-4">
                                <a href="{{ route('login') }}?redirect={{ urlencode(route('events.register', $event->slug)) }}" 
                                   class="block w-full text-center bg-gradient-to-r from-blue-600 to-blue-700 text-white py-4 rounded-lg font-bold hover:from-blue-700 hover:to-blue-800 transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <i class="fas fa-sign-in-alt mr-2"></i> Login untuk Mendaftar
                                </a>
                                <p class="text-center text-sm text-gray-600 mt-2">
                                    Belum punya akun? 
                                    <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-semibold">Daftar di sini</a>
                                </p>
                            </div>
                            
                            <!-- Info Alert -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                                <div class="flex items-start gap-2 text-blue-800 text-xs">
                                    <i class="fas fa-info-circle mt-0.5"></i>
                                    <div>
                                        <span class="font-semibold">Login diperlukan</span>
                                        <span class="block mt-1">Anda harus login terlebih dahulu untuk mendaftar event ini.</span>
                                    </div>
                                </div>
                            </div>
                        @endauth

                        <!-- Registration Info (Only for logged in users) -->
                        @auth
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                                <div class="flex items-start gap-2 text-blue-800 text-xs">
                                    <i class="fas fa-info-circle mt-0.5"></i>
                                    <div>
                                        <span class="font-semibold">Pendaftaran mudah & cepat!</span>
                                        <span class="block mt-1">✓ Konfirmasi instan ✓ E-ticket otomatis ✓ Reminder H-1</span>
                                    </div>
                                </div>
                            </div>
                        @endauth
                    @elseif($event->is_full)
                        <!-- Sold Out -->
                        <button disabled class="w-full bg-red-500 text-white py-4 rounded-lg font-bold cursor-not-allowed opacity-75 mb-4">
                            <i class="fas fa-times-circle mr-2"></i> SOLD OUT - Event Penuh
                        </button>
                        
                        <!-- Waiting List Option -->
                        <a href="mailto:{{ $event->contact_email ?? 'info@hastanaindonesia.or.id' }}?subject=Waiting List - {{ $event->title }}" 
                           class="block w-full text-center bg-gray-100 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-200 transition duration-200 mb-4">
                            <i class="fas fa-list-ul mr-2"></i> Gabung Waiting List
                        </a>
                    @elseif($event->is_past)
                        <!-- Event Already Passed -->
                        <button disabled class="w-full bg-gray-400 text-white py-4 rounded-lg font-bold cursor-not-allowed mb-4">
                            <i class="fas fa-calendar-times mr-2"></i> Event Sudah Berakhir
                        </button>
                    @else
                        <!-- Inactive or Unpublished -->
                        <button disabled class="w-full bg-gray-400 text-white py-4 rounded-lg font-bold cursor-not-allowed mb-4">
                            <i class="fas fa-ban mr-2"></i> Pendaftaran Ditutup
                        </button>
                    @endif

                    <!-- Share Button -->
                    <button onclick="shareEvent()" class="w-full bg-gray-100 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-200 transition duration-200">
                        <i class="fas fa-share-alt mr-2"></i> Bagikan Event
                    </button>
                </div>

                <script>
                function shareEvent() {
                    const eventUrl = window.location.href;
                    const eventTitle = "{{ $event->title }}";
                    
                    if (navigator.share) {
                        navigator.share({
                            title: eventTitle,
                            text: 'Yuk ikutan event ini!',
                            url: eventUrl
                        }).catch(err => console.log('Error sharing:', err));
                    } else {
                        // Fallback: Copy to clipboard
                        navigator.clipboard.writeText(eventUrl).then(() => {
                            alert('Link event berhasil dicopy! Bagikan ke teman-temanmu.');
                        }).catch(err => {
                            console.error('Failed to copy:', err);
                        });
                    }
                }
                </script>

                <!-- Event Details -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Detail Event</h3>
                    
                    <div class="space-y-4">
                        <!-- Date & Time -->
                        <div class="flex items-start gap-3">
                            <i class="fas fa-calendar-alt text-blue-600 text-xl mt-1"></i>
                            <div>
                                <div class="font-semibold text-gray-900">Tanggal & Waktu</div>
                                <div class="text-sm text-gray-600">
                                    {{ $event->start_date->format('l, d F Y') }}
                                    @if($event->start_date->format('Y-m-d') != $event->end_date->format('Y-m-d'))
                                        <br>s/d {{ $event->end_date->format('l, d F Y') }}
                                    @endif
                                </div>
                                @if($event->start_time)
                                    <div class="text-sm text-gray-600">
                                        {{ substr($event->start_time, 0, 5) }} - {{ substr($event->end_time, 0, 5) }} WIB
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-red-600 text-xl mt-1"></i>
                            <div>
                                <div class="font-semibold text-gray-900">Lokasi</div>
                                <div class="text-sm text-gray-600">
                                    {{ $event->location }}
                                    @if($event->venue)
                                        <br>{{ $event->venue }}
                                    @endif
                                    <br>{{ $event->city }}{{ $event->province ? ', ' . $event->province : '' }}
                                </div>
                            </div>
                        </div>

                        <!-- Organizer -->
                        @if($event->organizer_name)
                            <div class="flex items-start gap-3">
                                <i class="fas fa-building text-purple-600 text-xl mt-1"></i>
                                <div>
                                    <div class="font-semibold text-gray-900">Penyelenggara</div>
                                    <div class="text-sm text-gray-600">{{ $event->organizer_name }}</div>
                                </div>
                            </div>
                        @endif

                        <!-- Contact -->
                        @if($event->contact_email || $event->contact_phone)
                            <div class="flex items-start gap-3">
                                <i class="fas fa-phone text-green-600 text-xl mt-1"></i>
                                <div>
                                    <div class="font-semibold text-gray-900">Kontak</div>
                                    @if($event->contact_email)
                                        <div class="text-sm text-gray-600">
                                            <i class="fas fa-envelope"></i> {{ $event->contact_email }}
                                        </div>
                                    @endif
                                    @if($event->contact_phone)
                                        <div class="text-sm text-gray-600">
                                            <i class="fas fa-phone"></i> {{ $event->contact_phone }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tags -->
                @if($event->tags)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $tags = is_string($event->tags) ? json_decode($event->tags, true) : $event->tags;
                            @endphp
                            @if(is_array($tags))
                                @foreach($tags as $tag)
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                        #{{ $tag }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
