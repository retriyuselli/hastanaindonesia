@extends('layouts.app')

@section('title', 'Events - HASTANA Indonesia')
@section('description', 'Event dan kegiatan HASTANA Indonesia. Training, workshop, dan networking untuk wedding organizer profesional.')

@push('styles')
<style>
    .event-card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .event-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        border-color: #3b82f6;
    }
    
    .event-status {
        position: absolute;
        top: 1rem;
        right: 1rem;
        z-index: 10;
    }
    
    .filter-tab {
        transition: all 0.3s ease;
    }
    
    .filter-tab.active {
        background: var(--category-color, linear-gradient(135deg, #1e40af, #dc2626));
        color: white;
        border-color: var(--category-color, #1e40af) !important;
        transform: scale(1.05);
    }
    
    .filter-tab:not(.active):hover {
        border-color: var(--category-color, #3B82F6);
        color: var(--category-color, #1e40af);
    }
    
    .timeline-item {
        position: relative;
        padding-left: 2rem;
    }
    
    .timeline-item:before {
        content: '';
        position: absolute;
        left: 0.5rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, #3b82f6, #dc2626);
    }
    
    .timeline-dot {
        position: absolute;
        left: 0;
        top: 1rem;
        width: 1rem;
        height: 1rem;
        background: #3b82f6;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 0 0 3px #3b82f6;
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-r from-red-900 via-red-800 to-blue-800 py-16 text-white mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-4xl mx-auto">
            <div class="mb-6">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-5 backdrop-blur-sm">
                    <i class="fas fa-calendar-alt text-white text-2xl"></i>
                </div>
            </div>
            
            <h1 class="font-poppins text-3xl md:text-5xl font-bold mb-5 leading-tight">
                Events & <span class="text-yellow-300">Kegiatan</span>
            </h1>
            
            <p class="text-lg md:text-xl mb-6 leading-relaxed opacity-90">
                Training, Workshop, dan Networking untuk Wedding Organizer
            </p>
            
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <div class="bg-white/20 backdrop-blur-sm rounded-full px-5 py-2.5">
                    <span class="text-xs font-semibold">📅 25+ Events per Tahun</span>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-full px-5 py-2.5">
                    <span class="text-xs font-semibold">🏆 Sertifikat Resmi</span>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-full px-5 py-2.5">
                    <span class="text-xs font-semibold">🤝 Networking Premium</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filter Tabs -->
<section class="py-10 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Kategori Event</h2>
            <p class="text-sm text-gray-600">Pilih kategori event sesuai minat Anda</p>
        </div>
        
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('events') }}" 
               class="filter-tab {{ !request('type') ? 'active' : '' }} px-5 py-2.5 rounded-full border-2 border-gray-300 bg-white text-gray-700 text-sm font-semibold hover:bg-blue-50 hover:border-blue-500 transition-all duration-300">
                <i class="fas fa-th mr-1.5 text-xs"></i>
                Semua Events
            </a>
            
            @foreach($eventCategories as $category)
            <a href="{{ route('events', ['type' => $category->slug]) }}" 
               class="filter-tab {{ request('type') == $category->slug ? 'active' : '' }} px-5 py-2.5 rounded-full border-2 border-gray-300 bg-white text-gray-700 text-sm font-semibold hover:bg-blue-50 hover:border-blue-500 transition-all duration-300"
               style="--category-color: {{ $category->color ?? '#3B82F6' }}">
                @if($category->icon)
                <i class="fas fa-{{ $category->icon }} mr-1.5 text-xs"></i>
                @endif
                {{ $category->name }}
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Upcoming Events -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">
                Events <span class="bg-gradient-to-r from-blue-600 to-red-600 bg-clip-text text-transparent">
                    {{ $hasUpcomingEvents ? 'Mendatang' : 'Terbaru' }}
                </span>
            </h2>
            <p class="text-base text-gray-600">
                @if($hasUpcomingEvents)
                    Jangan lewatkan kesempatan emas untuk mengembangkan skill dan networking
                @else
                    Lihat koleksi event HASTANA Indonesia yang telah dilaksanakan
                @endif
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="events-grid">
            
            @if($events->count() > 0)
                @foreach($events as $event)
                <!-- Event Card -->
                <div class="event-card bg-white rounded-2xl shadow-lg overflow-hidden relative hover:shadow-2xl transition-shadow duration-300" 
                     data-category="{{ $event->event_type }}">
                    
                    @if($event->badge_type)
                    <div class="event-status">
                        <span class="bg-{{ $event->badge_color }} text-white px-2.5 py-1 rounded-full text-xs font-bold uppercase">
                            {{ $event->badge_label }}
                        </span>
                    </div>
                    @endif
                    
                    <div class="relative">
                        <img src="{{ $event->featured_image_url }}" 
                             alt="{{ $event->title }}" 
                             class="w-full h-44 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute bottom-3 left-3 text-white">
                            <span class="bg-white/20 backdrop-blur-sm px-2.5 py-1 rounded-full text-xs capitalize">
                                {{ str_replace('_', ' ', $event->event_type) }}
                            </span>
                        </div>
                        @if($event->is_premium)
                        <div class="absolute top-3 right-3">
                            <span class="bg-yellow-500 text-white px-2.5 py-1 rounded-full text-xs font-bold">
                                <i class="fas fa-crown mr-1"></i>PREMIUM
                            </span>
                        </div>
                        @endif
                    </div>
                    
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center text-xs text-gray-500">
                                <i class="fas fa-calendar mr-1.5 text-blue-600"></i>
                                <span>{{ $event->formatted_date }}</span>
                            </div>
                            @if($event->city)
                            <div class="flex items-center text-xs text-gray-500">
                                <i class="fas fa-map-marker-alt mr-1.5 text-red-600"></i>
                                <span>{{ $event->city }}</span>
                            </div>
                            @endif
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-900 mb-2 hover:text-blue-600 transition-colors">
                            <a href="{{ route('events.show', $event->slug) }}">
                                {{ Str::limit($event->title, 50) }}
                            </a>
                        </h3>
                        
                        <p class="text-gray-600 mb-3 text-xs leading-relaxed">
                            {{ Str::limit($event->short_description ?? $event->description, 120) }}
                        </p>
                        
                        <div class="flex items-center justify-between mb-3 pb-3 border-b border-gray-100">
                            @if($event->quota)
                            <div class="text-xs">
                                <span class="text-gray-500">Kuota:</span>
                                <span class="font-semibold text-blue-600">{{ $event->remaining_quota }} tersisa</span>
                            </div>
                            @endif
                            
                            <div class="text-xs">
                                <span class="text-gray-500">Harga:</span>
                                <span class="font-semibold {{ $event->is_free ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $event->formatted_price }}
                                </span>
                            </div>
                        </div>
                        
                        @if($event->speaker)
                        <div class="mb-3 text-xs">
                            <span class="text-gray-500">Speaker:</span>
                            <span class="font-semibold text-gray-900">{{ Str::limit($event->speaker, 30) }}</span>
                        </div>
                        @endif
                        
                        <div class="flex space-x-2">
                            @if($event->canRegister())
                            <a href="{{ $event->registration_link ?: route('events.show', $event->slug) }}" 
                               class="flex-1 bg-blue-600 text-white py-2.5 px-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold text-xs text-center">
                                <i class="fas fa-ticket-alt mr-1.5"></i>Daftar
                            </a>
                            @else
                            <button disabled 
                                    class="flex-1 bg-gray-400 text-white py-2.5 px-3 rounded-lg cursor-not-allowed font-semibold text-xs">
                                <i class="fas fa-times-circle mr-1.5"></i>Penuh
                            </button>
                            @endif
                            
                            <a href="{{ route('events.show', $event->slug) }}" 
                               class="flex-1 border border-blue-600 text-blue-600 py-2.5 px-3 rounded-lg hover:bg-blue-50 transition-colors font-semibold text-xs text-center">
                                <i class="fas fa-info-circle mr-1.5"></i>Detail
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Event Card -->
                @endforeach
            @else
                <!-- Empty State -->
                <div class="col-span-full text-center py-12">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-5">
                        <i class="fas fa-calendar-times text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Event</h3>
                    <p class="text-sm text-gray-600 mb-6">
                        @if(request('search') || request('type') || request('city'))
                            Tidak ada event yang sesuai dengan pencarian Anda. Coba ubah filter pencarian.
                        @else
                            Saat ini belum ada event yang tersedia. Pantau terus untuk update terbaru!
                        @endif
                    </p>
                    @if(request('search') || request('type') || request('city'))
                    <a href="{{ route('events') }}" 
                       class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                        <i class="fas fa-redo mr-1.5"></i>Reset Filter
                    </a>
                    @endif
                </div>
            @endif

        </div>
        
        <!-- Pagination -->
        @if($events->hasPages())
        <div class="mt-10">
            {{ $events->links() }}
        </div>
        @endif
    </div>
</section>

<!-- Event Timeline -->
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">Timeline Events 2025</h2>
            <p class="text-base text-gray-600">Jadwal lengkap events HASTANA sepanjang tahun</p>
        </div>
        
        <div class="space-y-6">
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="bg-white rounded-xl p-5 shadow-lg ml-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-base font-bold">Q1 2025</h3>
                        <span class="bg-blue-100 text-blue-800 px-2.5 py-1 rounded-full text-xs">Januari - Maret</span>
                    </div>
                    <ul class="space-y-1.5 text-gray-600 text-sm">
                        <li>• Workshop Photography Masterclass - Jakarta</li>
                        <li>• Premium Networking Dinner - Surabaya</li>
                        <li>• Business Development Training - Bandung</li>
                        <li>• HASTANA Annual Conference - Bali</li>
                    </ul>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-dot bg-green-600" style="box-shadow: 0 0 0 3px #16a34a;"></div>
                <div class="bg-white rounded-xl p-5 shadow-lg ml-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-base font-bold">Q2 2025</h3>
                        <span class="bg-green-100 text-green-800 px-2.5 py-1 rounded-full text-xs">April - Juni</span>
                    </div>
                    <ul class="space-y-1.5 text-gray-600 text-sm">
                        <li>• Vendor Expo & Exhibition - Jakarta</li>
                        <li>• International Wedding Trends Seminar</li>
                        <li>• Regional Chapter Meetings</li>
                        <li>• Sustainability in Wedding Workshop</li>
                    </ul>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-dot bg-yellow-600" style="box-shadow: 0 0 0 3px #ca8a04;"></div>
                <div class="bg-white rounded-xl p-5 shadow-lg ml-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-base font-bold">Q3 2025</h3>
                        <span class="bg-yellow-100 text-yellow-800 px-2.5 py-1 rounded-full text-xs">Juli - September</span>
                    </div>
                    <ul class="space-y-1.5 text-gray-600 text-sm">
                        <li>• Summer Networking Festival - Bali</li>
                        <li>• Digital Marketing Intensive Course</li>
                        <li>• Young Entrepreneur Workshop</li>
                        <li>• Wedding Planner Certification Program</li>
                    </ul>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-dot bg-red-600" style="box-shadow: 0 0 0 3px #dc2626;"></div>
                <div class="bg-white rounded-xl p-5 shadow-lg ml-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-base font-bold">Q4 2025</h3>
                        <span class="bg-red-100 text-red-800 px-2.5 py-1 rounded-full text-xs">Oktober - Desember</span>
                    </div>
                    <ul class="space-y-1.5 text-gray-600 text-sm">
                        <li>• End Year Gala & Awards Night</li>
                        <li>• Business Planning for 2026 Workshop</li>
                        <li>• Member Appreciation Event</li>
                        <li>• New Year Networking Party</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Event Benefits -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">
                Benefit <span class="bg-gradient-to-r from-blue-600 to-red-600 bg-clip-text text-transparent">Mengikuti Events</span>
            </h2>
            <p class="text-base text-gray-600">Keuntungan yang Anda dapatkan dari setiap event HASTANA</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-certificate text-white text-xl"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-2">Sertifikat Resmi</h3>
                <p class="text-gray-600 text-xs">E-certificate yang diakui industri untuk setiap event yang Anda ikuti</p>
            </div>
            
            <div class="text-center">
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-2">Premium Networking</h3>
                <p class="text-gray-600 text-xs">Bertemu dengan 500+ wedding organizer profesional dari seluruh Indonesia</p>
            </div>
            
            <div class="text-center">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-brain text-white text-xl"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-2">Knowledge Update</h3>
                <p class="text-gray-600 text-xs">Update terbaru tentang tren, teknologi, dan best practices industri wedding</p>
            </div>
            
            <div class="text-center">
                <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-gift text-white text-xl"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-2">Exclusive Perks</h3>
                <p class="text-gray-600 text-xs">Doorprize, merchandise eksklusif, dan special offer dari sponsor</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-blue-600 to-red-600 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl md:text-3xl font-bold mb-5">
            Siap Bergabung di Event Berikutnya?
        </h2>
        <p class="text-lg mb-6 opacity-90">
            Jangan lewatkan kesempatan untuk networking dan upgrade skill bersama komunitas wedding organizer terbaik Indonesia
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('join') }}" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-bold text-sm rounded-full hover:bg-gray-100 transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-user-plus mr-2 text-xs"></i>
                Bergabung HASTANA
            </a>
            <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 border-2 border-white text-white font-bold text-sm rounded-full hover:bg-white hover:text-blue-600 transition-all duration-300">
                <i class="fas fa-phone mr-2 text-xs"></i>
                Tanya Event Info
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const filterTabs = document.querySelectorAll('.filter-tab');
        const eventCards = document.querySelectorAll('.event-card');

        filterTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                
                // Update active tab
                filterTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                // Filter events
                eventCards.forEach(card => {
                    const categories = card.getAttribute('data-category');
                    
                    if (filter === 'all' || categories.includes(filter)) {
                        card.style.display = 'block';
                        card.style.animation = 'fadeIn 0.5s ease-in-out';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe timeline items
        document.querySelectorAll('.timeline-item').forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(item);
        });
    });

    // Add fade in animation CSS
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    `;
    document.head.appendChild(style);
</script>
@endpush
