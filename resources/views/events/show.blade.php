@extends('layouts.app')

@section('title', $event->title . ' - Event HASTANA Indonesia')

@section('content')
<!-- Event Hero Section -->
<section class="text-gray-800 py-6 mt-20">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-2 text-xs mb-3">
            <a href="{{ route('home') }}" class="hover:underline">Home</a>
            <span>/</span>
            <a href="{{ route('events') }}" class="hover:underline">Event</a>
            <span>/</span>
            <span class="text-blue-800">{{ $event->title }}</span>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-6 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Main Content -->
            <div class="lg:w-2/3">
                <!-- Event Header Card -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-5">
                    <!-- Event Image -->
                    <div class="relative h-80 bg-gray-200">
                        @if($event->image)
                            <img src="{{ Storage::url($event->image) }}"
                                 alt="{{ $event->title }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-500 to-blue-700">
                                <i class="fas fa-calendar-alt text-white text-7xl"></i>
                            </div>
                        @endif
                        
                        <!-- Badges -->
                        <div class="absolute top-3 left-3 flex gap-1.5">
                            @if($event->is_featured)
                                <span class="bg-yellow-500 text-white px-2.5 py-1 rounded-full text-xs font-semibold">
                                    <i class="fas fa-star"></i> Featured
                                </span>
                            @endif
                            @if($event->is_trending)
                                <span class="bg-red-500 text-white px-2.5 py-1 rounded-full text-xs font-semibold">
                                    <i class="fas fa-fire"></i> Trending
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Event Info -->
                    <div class="p-5">
                        <!-- Category & Type -->
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-blue-100 text-blue-800 px-2.5 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-tag"></i> {{ $event->eventCategory->name ?? 'Uncategorized' }}
                            </span>
                            <span class="bg-gray-100 text-gray-800 px-2.5 py-1 rounded-full text-xs">
                                {{ $event->event_type == 'internal' ? 'Internal' : 'Eksternal' }}
                            </span>
                            <span class="bg-{{ $event->status == 'published' ? 'green' : 'gray' }}-100 text-{{ $event->status == 'published' ? 'green' : 'gray' }}-800 px-2.5 py-1 rounded-full text-xs">
                                {{ ucfirst($event->status) }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">
                            {{ $event->title }}
                        </h1>

                        <!-- Short Description -->
                        @if($event->short_description)
                            <p class="text-base text-gray-600 mb-5">
                                {{ $event->short_description }}
                            </p>
                        @endif

                        <!-- Event Stats -->
                        <div class="flex flex-wrap justify-center gap-5 md:gap-6 p-5 bg-gray-50 rounded-lg">
                            <div class="text-center min-w-[100px]">
                                <i class="fas fa-users text-blue-600 text-xl mb-1.5"></i>
                                <div class="text-xl font-bold text-gray-900">{{ $event->current_participants }}</div>
                                <div class="text-xs text-gray-600">Peserta Terdaftar</div>
                            </div>
                            <div class="text-center min-w-[100px]">
                                <i class="fas fa-ticket-alt text-green-600 text-xl mb-1.5"></i>
                                <div class="text-xl font-bold text-gray-900">
                                    {{ $event->capacity ? $event->remaining_quota : 'Unlimited' }}
                                </div>
                                <div class="text-xs text-gray-600">Sisa Kuota</div>
                            </div>
                            @if($event->rating > 0)
                                <div class="text-center min-w-[100px]">
                                    <i class="fas fa-star text-yellow-500 text-xl mb-1.5"></i>
                                    <div class="text-xl font-bold text-gray-900">{{ number_format($event->rating, 1) }}</div>
                                    <div class="text-xs text-gray-600">Rating</div>
                                </div>
                            @endif
                            <div class="text-center min-w-[100px]">
                                <i class="fas fa-eye text-purple-600 text-xl mb-1.5"></i>
                                <div class="text-xl font-bold text-gray-900">{{ $event->total_reviews }}</div>
                                <div class="text-xs text-gray-600">Reviews</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-lg shadow-lg p-5 mb-5">
                    <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i> Deskripsi Event
                    </h2>
                    <div class="event-description prose max-w-none text-gray-700">
                        {!! $event->description !!}
                    </div>
                </div>

                <style>
                .event-description {
                    font-family: 'Poppins', 'Inter', system-ui, -apple-system, sans-serif;
                    line-height: 1.8;
                    color: #374151;
                }

                /* Paragraphs */
                .event-description p {
                    font-size: 14px;
                    margin-bottom: 1rem;
                    text-align: justify;
                    color: #4b5563;
                }

                /* Drop Cap - First Letter */
                /* .event-description p:first-of-type::first-letter {
                    font-size: 3.5em;
                    font-weight: 700;
                    line-height: 0.9;
                    float: left;
                    margin: 0.1em 0.15em 0 0;
                    color: #3b82f6;
                    font-family: Georgia, serif;
                } */

                /* Headings */
                .event-description h1 {
                    font-size: 26px;
                    font-weight: 700;
                    margin: 1.5rem 0 1rem 0;
                    color: #1f2937;
                    padding-left: 1rem;
                    border-left: 5px solid transparent;
                    background: linear-gradient(90deg, #3b82f6 0%, #8b5cf6 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                    position: relative;
                }

                .event-description h1::before {
                    content: '';
                    position: absolute;
                    left: 0;
                    top: 0;
                    bottom: 0;
                    width: 5px;
                    background: linear-gradient(180deg, #3b82f6 0%, #8b5cf6 100%);
                    border-radius: 2px;
                }

                .event-description h2 {
                    font-size: 22px;
                    font-weight: 700;
                    margin: 1.5rem 0 1rem 0;
                    color: #1f2937;
                    padding-left: 1rem;
                    border-left: 4px solid transparent;
                    background: linear-gradient(90deg, #3b82f6 0%, #06b6d4 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                    position: relative;
                }

                .event-description h2::before {
                    content: '';
                    position: absolute;
                    left: 0;
                    top: 0;
                    bottom: 0;
                    width: 4px;
                    background: linear-gradient(180deg, #3b82f6 0%, #06b6d4 100%);
                    border-radius: 2px;
                }

                .event-description h3 {
                    font-size: 18px;
                    font-weight: 600;
                    margin: 1.25rem 0 0.75rem 0;
                    color: #1f2937;
                    padding-left: 0.75rem;
                    border-left: 3px solid #3b82f6;
                }

                .event-description h4 {
                    font-size: 16px;
                    font-weight: 600;
                    margin: 1rem 0 0.5rem 0;
                    color: #374151;
                    padding-left: 0.5rem;
                    border-left: 2px solid #60a5fa;
                }

                /* Lists */
                .event-description ul,
                .event-description ol {
                    margin: 1rem 0;
                    padding-left: 1.5rem;
                }

                .event-description ul li {
                    font-size: 14px;
                    margin-bottom: 0.5rem;
                    color: #4b5563;
                    position: relative;
                    padding-left: 1.5rem;
                    list-style: none;
                }

                .event-description ul li::before {
                    content: "▸";
                    position: absolute;
                    left: 0;
                    color: #3b82f6;
                    font-weight: bold;
                    font-size: 16px;
                }

                .event-description ol {
                    counter-reset: item;
                }

                .event-description ol li {
                    font-size: 14px;
                    margin-bottom: 0.5rem;
                    color: #4b5563;
                    position: relative;
                    padding-left: 2rem;
                    list-style: none;
                    counter-increment: item;
                }

                .event-description ol li::before {
                    content: counter(item);
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 24px;
                    height: 24px;
                    background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
                    color: white;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 12px;
                    font-weight: 600;
                }

                /* Blockquote */
                .event-description blockquote {
                    font-size: 14px;
                    padding: 1rem 1rem 1rem 3.5rem;
                    margin: 1.5rem 0;
                    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
                    border-left: 4px solid #3b82f6;
                    border-radius: 0.5rem;
                    position: relative;
                    font-style: italic;
                    color: #1e40af;
                }

                .event-description blockquote::before {
                    content: '"';
                    position: absolute;
                    left: 1rem;
                    top: 0.5rem;
                    font-size: 48px;
                    color: #3b82f6;
                    opacity: 0.3;
                    font-family: Georgia, serif;
                    line-height: 1;
                }

                /* Strong Text */
                .event-description strong {
                    font-weight: 600;
                    color: #1f2937;
                    background: linear-gradient(180deg, transparent 60%, #fef3c7 60%);
                    padding: 0 0.2em;
                }

                /* Emphasis */
                .event-description em {
                    font-style: italic;
                    color: #6366f1;
                }

                /* Links */
                .event-description a {
                    color: #3b82f6;
                    text-decoration: none;
                    font-weight: 500;
                    position: relative;
                    transition: color 0.2s;
                }

                .event-description a::after {
                    content: '';
                    position: absolute;
                    left: 0;
                    bottom: -2px;
                    width: 0;
                    height: 2px;
                    background: linear-gradient(90deg, #3b82f6 0%, #8b5cf6 100%);
                    transition: width 0.3s ease;
                }

                .event-description a:hover {
                    color: #2563eb;
                }

                .event-description a:hover::after {
                    width: 100%;
                }

                /* Code */
                .event-description code {
                    font-size: 13px;
                    padding: 0.2em 0.5em;
                    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
                    border: 1px solid #fbbf24;
                    border-radius: 0.25rem;
                    font-family: 'Courier New', monospace;
                    color: #92400e;
                }

                .event-description pre {
                    background: #1f2937;
                    padding: 1rem;
                    border-radius: 0.5rem;
                    overflow-x: auto;
                    margin: 1rem 0;
                }

                .event-description pre code {
                    background: transparent;
                    border: none;
                    color: #e5e7eb;
                    padding: 0;
                }

                /* Images */
                .event-description img {
                    max-width: 100%;
                    height: auto;
                    border-radius: 0.5rem;
                    margin: 1.5rem auto;
                    display: block;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                    transition: transform 0.3s ease;
                }

                .event-description img:hover {
                    transform: scale(1.02);
                }

                /* Tables */
                .event-description table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 1.5rem 0;
                    font-size: 13px;
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                    border-radius: 0.5rem;
                    overflow: hidden;
                }

                .event-description table thead {
                    background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
                    color: white;
                }

                .event-description table th {
                    padding: 0.75rem;
                    text-align: left;
                    font-weight: 600;
                    font-size: 13px;
                }

                .event-description table td {
                    padding: 0.75rem;
                    border-bottom: 1px solid #e5e7eb;
                }

                .event-description table tbody tr:nth-child(even) {
                    background-color: #f9fafb;
                }

                .event-description table tbody tr:hover {
                    background-color: #eff6ff;
                }

                /* Horizontal Rule */
                .event-description hr {
                    border: none;
                    height: 2px;
                    background: linear-gradient(90deg, transparent 0%, #3b82f6 50%, transparent 100%);
                    margin: 2rem 0;
                }
                </style>

                <!-- Benefits -->
                @if(count($benefits) > 0)
                    <div class="bg-white rounded-lg shadow-lg p-5 mb-5">
                        <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center">
                            <i class="fas fa-gift text-green-600 mr-2"></i> Yang Akan Anda Dapatkan
                        </h2>
                        <ul class="space-y-2">
                            @foreach($benefits as $benefit)
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                    <span class="text-gray-700 text-sm">{{ trim($benefit) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Requirements -->
                @if(count($requirements) > 0)
                    <div class="bg-white rounded-lg shadow-lg p-5 mb-5">
                        <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center">
                            <i class="fas fa-clipboard-list text-orange-600 mr-2"></i> Persyaratan
                        </h2>
                        <ul class="space-y-2">
                            @foreach($requirements as $requirement)
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-exclamation-circle text-orange-500 mt-0.5"></i>
                                    <span class="text-gray-700 text-sm">{{ trim($requirement) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Related Events -->
                @if($relatedEvents->count() > 0)
                    <div class="bg-white rounded-lg shadow-lg p-5">
                        <h2 class="text-xl font-bold text-gray-900 mb-5 flex items-center">
                            <i class="fas fa-calendar-alt text-blue-600 mr-2"></i> Event Terkait
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($relatedEvents as $related)
                                <a href="{{ route('events.show', $related->slug) }}" class="block group">
                                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                                        <div class="h-28 bg-gray-200 relative">
                                            @if($related->image)
                                                <img src="{{ Storage::url($related->image) }}" 
                                                     alt="{{ $related->title }}" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                                                    <i class="fas fa-calendar text-white text-2xl"></i>
                                                </div>
                                            @endif
                                            @if($related->is_free)
                                                <span class="absolute top-1.5 right-1.5 bg-green-500 text-white text-xs px-1.5 py-0.5 rounded-full font-semibold">
                                                    GRATIS
                                                </span>
                                            @endif
                                        </div>
                                        <div class="p-2.5">
                                            <h3 class="font-semibold text-sm text-gray-900 group-hover:text-blue-600 line-clamp-2 mb-1.5">
                                                {{ $related->title }}
                                            </h3>
                                            <div class="flex items-center text-xs text-gray-600 gap-2">
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
                <div class="bg-white rounded-lg shadow-lg p-5 sticky top-24 mb-5">
                    <!-- Price -->
                    <div class="text-center mb-5">
                        @if($event->is_free)
                            <div class="text-3xl font-bold text-green-600 mb-1.5">
                                <i class="fas fa-gift"></i> GRATIS
                            </div>
                            <p class="text-gray-600 text-sm">Event ini gratis untuk semua peserta</p>
                        @else
                            <div class="text-3xl font-bold text-blue-600 mb-1.5">
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                            </div>
                            <p class="text-gray-600 text-sm">Per peserta</p>
                        @endif
                    </div>

                    <!-- Capacity Progress -->
                    @if($event->max_participants || $event->quota)
                        <div class="mb-5">
                            <div class="flex justify-between text-xs text-gray-600 mb-1.5">
                                <span>Kapasitas Terisi</span>
                                <span class="font-semibold">{{ number_format($event->capacity_percentage, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
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
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-3">
                            <div class="flex items-center gap-2.5 text-green-800 mb-2.5">
                                <i class="fas fa-check-circle text-xl"></i>
                                <div>
                                    <p class="font-bold text-base">Anda Sudah Terdaftar!</p>
                                    <p class="text-xs">Lihat detail registrasi Anda di Event Saya</p>
                                </div>
                            </div>
                            <a href="{{ route('dashboard') }}" class="block w-full text-center bg-green-600 text-white py-2.5 rounded-lg font-semibold hover:bg-green-700 transition duration-200 text-sm">
                                <i class="fas fa-tachometer-alt mr-2"></i>
                                Lihat Dashboard Saya
                            </a>
                        </div>
                    @elseif($canRegister)
                        @if($isAlmostFull)
                            <!-- Almost Full Alert -->
                            <div class="bg-red-50 border border-red-200 rounded-lg p-2.5 mb-2.5 animate-pulse">
                                <div class="flex items-center gap-2 text-red-800 text-xs font-semibold">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span>Hanya {{ $event->remaining_quota }} slot tersisa! Buruan daftar!</span>
                                </div>
                            </div>
                        @endif

                        @auth
                            <!-- User logged in - can register -->
                            <a href="{{ route('events.register', $event->slug) }}" 
                               class="block w-full text-center bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-lg font-bold hover:from-blue-700 hover:to-blue-800 transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 mb-3 text-sm">
                                <i class="fas fa-user-plus mr-2"></i> 
                                @if($event->is_free)
                                    Daftar Gratis Sekarang
                                @else
                                    Daftar & Bayar - Rp {{ number_format($event->price, 0, ',', '.') }}
                                @endif
                            </a>
                        @else
                            <!-- User not logged in - show login prompt -->
                            <div class="mb-3">
                                <a href="{{ route('login') }}?redirect={{ urlencode(route('events.register', $event->slug)) }}" 
                                   class="block w-full text-center bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-lg font-bold hover:from-blue-700 hover:to-blue-800 transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm">
                                    <i class="fas fa-sign-in-alt mr-2"></i> Login untuk Mendaftar
                                </a>
                                <p class="text-center text-xs text-gray-600 mt-1.5">
                                    Belum punya akun? 
                                    <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-semibold">Daftar di sini</a>
                                </p>
                            </div>
                            
                            <!-- Info Alert -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-2.5 mb-3">
                                <div class="flex items-start gap-2 text-blue-800 text-xs">
                                    <i class="fas fa-info-circle mt-0.5"></i>
                                    <div>
                                        <span class="font-semibold">Login diperlukan</span>
                                        <span class="block mt-0.5">Anda harus login terlebih dahulu untuk mendaftar event ini.</span>
                                    </div>
                                </div>
                            </div>
                        @endauth

                        <!-- Registration Info (Only for logged in users) -->
                        @auth
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-2.5 mb-3">
                                <div class="flex items-start gap-2 text-blue-800 text-xs">
                                    <i class="fas fa-info-circle mt-0.5"></i>
                                    <div>
                                        <span class="font-semibold">Pendaftaran mudah & cepat!</span>
                                        <span class="block mt-0.5">✓ Konfirmasi instan ✓ E-ticket otomatis ✓ Reminder H-1</span>
                                    </div>
                                </div>
                            </div>
                        @endauth
                    @elseif($event->is_full)
                        <!-- Sold Out -->
                        <button disabled class="w-full bg-red-500 text-white py-3 rounded-lg font-bold cursor-not-allowed opacity-75 mb-3 text-sm">
                            <i class="fas fa-times-circle mr-2"></i> SOLD OUT - Event Penuh
                        </button>
                        
                        <!-- Waiting List Option -->
                        <a href="mailto:{{ $event->contact_email ?? 'info@hastanaindonesia.or.id' }}?subject=Waiting List - {{ $event->title }}" 
                           class="block w-full text-center bg-gray-100 text-gray-700 py-2.5 rounded-lg font-semibold hover:bg-gray-200 transition duration-200 mb-3 text-sm">
                            <i class="fas fa-list-ul mr-2"></i> Gabung Waiting List
                        </a>
                    @elseif($event->is_past)
                        <!-- Event Already Passed -->
                        <button disabled class="w-full bg-gray-400 text-white py-3 rounded-lg font-bold cursor-not-allowed mb-3 text-sm">
                            <i class="fas fa-calendar-times mr-2"></i> Event Sudah Berakhir
                        </button>
                    @else
                        <!-- Inactive or Unpublished -->
                        <button disabled class="w-full bg-gray-400 text-white py-3 rounded-lg font-bold cursor-not-allowed mb-3 text-sm">
                            <i class="fas fa-ban mr-2"></i> Pendaftaran Ditutup
                        </button>
                    @endif

                    <!-- Share Button -->
                    <button onclick="shareEvent()" class="w-full bg-gray-100 text-gray-700 py-2.5 rounded-lg font-semibold hover:bg-gray-200 transition duration-200 text-sm">
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
                <div class="bg-white rounded-lg shadow-lg p-5 mb-5">
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Detail Event</h3>
                    
                    <div class="space-y-3">
                        <!-- Date & Time -->
                        <div class="flex items-start gap-2.5">
                            <i class="fas fa-calendar-alt text-blue-600 text-lg mt-1"></i>
                            <div>
                                <div class="font-semibold text-gray-900 text-sm">Tanggal & Waktu</div>
                                <div class="text-xs text-gray-600">
                                    {{ $event->start_date->format('l, d F Y') }}
                                    @if($event->start_date->format('Y-m-d') != $event->end_date->format('Y-m-d'))
                                        <br>s/d {{ $event->end_date->format('l, d F Y') }}
                                    @endif
                                </div>
                                @if($event->start_time)
                                    <div class="text-xs text-gray-600">
                                        {{ substr($event->start_time, 0, 5) }} - {{ substr($event->end_time, 0, 5) }} WIB
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="flex items-start gap-2.5">
                            <i class="fas fa-map-marker-alt text-red-600 text-lg mt-1"></i>
                            <div>
                                <div class="font-semibold text-gray-900 text-sm">Lokasi</div>
                                <div class="text-xs text-gray-600">
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
                            <div class="flex items-start gap-2.5">
                                <i class="fas fa-building text-purple-600 text-lg mt-1"></i>
                                <div>
                                    <div class="font-semibold text-gray-900 text-sm">Penyelenggara</div>
                                    <div class="text-xs text-gray-600">{{ $event->organizer_name }}</div>
                                </div>
                            </div>
                        @endif

                        <!-- Contact -->
                        @if($event->contact_email || $event->contact_phone)
                            <div class="flex items-start gap-2.5">
                                <i class="fas fa-phone text-green-600 text-lg mt-1"></i>
                                <div>
                                    <div class="font-semibold text-gray-900 text-sm">Kontak</div>
                                    @if($event->contact_email)
                                        <div class="text-xs text-gray-600">
                                            <i class="fas fa-envelope"></i> {{ $event->contact_email }}
                                        </div>
                                    @endif
                                    @if($event->contact_phone)
                                        <div class="text-xs text-gray-600">
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
                    <div class="bg-white rounded-lg shadow-lg p-5">
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Tags</h3>
                        <div class="flex flex-wrap gap-1.5">
                            @php
                                $tags = is_string($event->tags) ? json_decode($event->tags, true) : $event->tags;
                            @endphp
                            @if(is_array($tags))
                                @foreach($tags as $tag)
                                    <span class="bg-blue-100 text-blue-800 px-2.5 py-1 rounded-full text-xs">
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
