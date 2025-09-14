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
        background: linear-gradient(135deg, #1e40af, #dc2626);
        color: white;
        transform: scale(1.05);
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
<section class="bg-gradient-to-r from-red-900 via-red-800 to-blue-800 py-20 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                    <i class="fas fa-calendar-alt text-white text-3xl"></i>
                </div>
            </div>
            
            <h1 class="font-poppins text-4xl md:text-6xl font-bold mb-6 leading-tight">
                Events & <span class="text-yellow-300">Kegiatan</span>
            </h1>
            
            <p class="text-xl md:text-2xl mb-8 leading-relaxed opacity-90">
                Training, Workshop, dan Networking untuk Wedding Organizer
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <div class="bg-white/20 backdrop-blur-sm rounded-full px-6 py-3">
                    <span class="text-sm font-semibold">📅 25+ Events per Tahun</span>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-full px-6 py-3">
                    <span class="text-sm font-semibold">🏆 Sertifikat Resmi</span>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-full px-6 py-3">
                    <span class="text-sm font-semibold">🤝 Networking Premium</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filter Tabs -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Kategori Event</h2>
            <p class="text-gray-600">Pilih kategori event sesuai minat Anda</p>
        </div>
        
        <div class="flex flex-wrap justify-center gap-4">
            <button class="filter-tab active px-6 py-3 rounded-full border-2 border-gray-300 bg-white text-gray-700 font-semibold" data-filter="all">
                Semua Events
            </button>
            <button class="filter-tab px-6 py-3 rounded-full border-2 border-gray-300 bg-white text-gray-700 font-semibold" data-filter="upcoming">
                Upcoming
            </button>
            <button class="filter-tab px-6 py-3 rounded-full border-2 border-gray-300 bg-white text-gray-700 font-semibold" data-filter="workshop">
                Workshop
            </button>
            <button class="filter-tab px-6 py-3 rounded-full border-2 border-gray-300 bg-white text-gray-700 font-semibold" data-filter="networking">
                Networking
            </button>
            <button class="filter-tab px-6 py-3 rounded-full border-2 border-gray-300 bg-white text-gray-700 font-semibold" data-filter="conference">
                Conference
            </button>
            <button class="filter-tab px-6 py-3 rounded-full border-2 border-gray-300 bg-white text-gray-700 font-semibold" data-filter="training">
                Training
            </button>
        </div>
    </div>
</section>

<!-- Upcoming Events -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Events <span class="bg-gradient-to-r from-blue-600 to-red-600 bg-clip-text text-transparent">Mendatang</span>
            </h2>
            <p class="text-lg text-gray-600">Jangan lewatkan kesempatan emas untuk mengembangkan skill dan networking</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="events-grid">
            
            <!-- Event 1 - Featured -->
            <div class="event-card bg-white rounded-2xl shadow-lg overflow-hidden relative md:col-span-2 lg:col-span-1" data-category="upcoming conference">
                <div class="event-status">
                    <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">FEATURED</span>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?w=600&h=300&fit=crop" alt="HASTANA Conference 2025" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-sm">Conference</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-calendar mr-2 text-blue-600"></i>
                            <span>15-17 Maret 2025</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt mr-2 text-red-600"></i>
                            <span>Bali</span>
                        </div>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-3">HASTANA Annual Conference 2025</h3>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        Konferensi tahunan terbesar dengan tema "Wedding Industry 4.0: Digital Transformation in Wedding Organizer Business". 
                        Hadiah doorprize senilai 50 juta rupiah!
                    </p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-sm">
                            <span class="text-gray-500">Peserta:</span>
                            <span class="font-semibold text-blue-600">500+ WO</span>
                        </div>
                        <div class="text-sm">
                            <span class="text-gray-500">Speaker:</span>
                            <span class="font-semibold text-green-600">10 Expert</span>
                        </div>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                            <i class="fas fa-ticket-alt mr-2"></i>Daftar
                        </button>
                        <button class="flex-1 border border-blue-600 text-blue-600 py-3 px-4 rounded-lg hover:bg-blue-50 transition-colors font-semibold">
                            <i class="fas fa-info-circle mr-2"></i>Detail
                        </button>
                    </div>
                </div>
            </div>

            <!-- Event 2 -->
            <div class="event-card bg-white rounded-2xl shadow-lg overflow-hidden relative" data-category="upcoming workshop">
                <div class="event-status">
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">OPEN</span>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1556761175-4b46a572b786?w=400&h=250&fit=crop" alt="Photography Workshop" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-sm">Workshop</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-calendar mr-2 text-blue-600"></i>
                            <span>25 Januari 2025</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt mr-2 text-red-600"></i>
                            <span>Jakarta</span>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Wedding Photography Masterclass</h3>
                    <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                        Workshop intensif fotografi pernikahan dengan equipment terbaru dan teknik editing professional.
                    </p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-sm">
                            <span class="text-gray-500">Quota:</span>
                            <span class="font-semibold text-orange-600">30 peserta</span>
                        </div>
                        <div class="text-sm">
                            <span class="text-gray-500">Harga:</span>
                            <span class="font-semibold text-green-600">Rp 750K</span>
                        </div>
                    </div>
                    
                    <button class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-2 px-4 rounded-lg hover:from-green-700 hover:to-green-800 transition-all font-semibold">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                    </button>
                </div>
            </div>

            <!-- Event 3 -->
            <div class="event-card bg-white rounded-2xl shadow-lg overflow-hidden relative" data-category="upcoming networking">
                <div class="event-status">
                    <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-bold">PREMIUM</span>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?w=400&h=250&fit=crop" alt="Networking Dinner" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-sm">Networking</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-calendar mr-2 text-blue-600"></i>
                            <span>8 Februari 2025</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt mr-2 text-red-600"></i>
                            <span>Surabaya</span>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Premium Networking Dinner</h3>
                    <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                        Malam networking eksklusif dengan top wedding organizer se-Jawa Timur. Premium venue dengan live music.
                    </p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-sm">
                            <span class="text-gray-500">Level:</span>
                            <span class="font-semibold text-purple-600">Gold+</span>
                        </div>
                        <div class="text-sm">
                            <span class="text-gray-500">Dress:</span>
                            <span class="font-semibold text-indigo-600">Formal</span>
                        </div>
                    </div>
                    
                    <button class="w-full bg-gradient-to-r from-purple-600 to-purple-700 text-white py-2 px-4 rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all font-semibold">
                        <i class="fas fa-crown mr-2"></i>Join Premium
                    </button>
                </div>
            </div>

            <!-- Event 4 -->
            <div class="event-card bg-white rounded-2xl shadow-lg overflow-hidden relative" data-category="upcoming training">
                <div class="event-status">
                    <span class="bg-yellow-500 text-gray-900 px-3 py-1 rounded-full text-xs font-bold">LIMITED</span>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=400&h=250&fit=crop" alt="Business Training" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-sm">Training</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-calendar mr-2 text-blue-600"></i>
                            <span>20 Februari 2025</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt mr-2 text-red-600"></i>
                            <span>Bandung</span>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Business Development Training</h3>
                    <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                        Pelatihan pengembangan bisnis WO dengan strategi marketing digital dan customer retention.
                    </p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-sm">
                            <span class="text-gray-500">Sisa:</span>
                            <span class="font-semibold text-red-600">5 slot</span>
                        </div>
                        <div class="text-sm">
                            <span class="text-gray-500">Benefit:</span>
                            <span class="font-semibold text-blue-600">E-Certificate</span>
                        </div>
                    </div>
                    
                    <button class="w-full bg-gradient-to-r from-yellow-600 to-orange-600 text-white py-2 px-4 rounded-lg hover:from-yellow-700 hover:to-orange-700 transition-all font-semibold">
                        <i class="fas fa-bolt mr-2"></i>Daftar Cepat
                    </button>
                </div>
            </div>

            <!-- Event 5 -->
            <div class="event-card bg-white rounded-2xl shadow-lg overflow-hidden relative" data-category="upcoming workshop">
                <div class="event-status">
                    <span class="bg-indigo-500 text-white px-3 py-1 rounded-full text-xs font-bold">NEW</span>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&h=250&fit=crop" alt="Digital Marketing" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-sm">Workshop</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-calendar mr-2 text-blue-600"></i>
                            <span>5 Maret 2025</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt mr-2 text-red-600"></i>
                            <span>Online</span>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Social Media Marketing for WO</h3>
                    <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                        Workshop online tentang strategi social media marketing khusus untuk wedding organizer. Include template konten.
                    </p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-sm">
                            <span class="text-gray-500">Format:</span>
                            <span class="font-semibold text-green-600">Online</span>
                        </div>
                        <div class="text-sm">
                            <span class="text-gray-500">Bonus:</span>
                            <span class="font-semibold text-purple-600">Template</span>
                        </div>
                    </div>
                    
                    <button class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-2 px-4 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all font-semibold">
                        <i class="fas fa-laptop mr-2"></i>Join Online
                    </button>
                </div>
            </div>

            <!-- Event 6 -->
            <div class="event-card bg-white rounded-2xl shadow-lg overflow-hidden relative" data-category="upcoming networking">
                <div class="event-status">
                    <span class="bg-pink-500 text-white px-3 py-1 rounded-full text-xs font-bold">FEMALE</span>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?w=400&h=250&fit=crop" alt="Women Networking" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-sm">Networking</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-calendar mr-2 text-blue-600"></i>
                            <span>10 Maret 2025</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt mr-2 text-red-600"></i>
                            <span>Yogyakarta</span>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Women in Wedding Industry</h3>
                    <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                        Gathering khusus untuk wanita pengusaha wedding organizer. Diskusi empowerment dan business growth.
                    </p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-sm">
                            <span class="text-gray-500">Target:</span>
                            <span class="font-semibold text-pink-600">Female WO</span>
                        </div>
                        <div class="text-sm">
                            <span class="text-gray-500">Theme:</span>
                            <span class="font-semibold text-purple-600">Empowerment</span>
                        </div>
                    </div>
                    
                    <button class="w-full bg-gradient-to-r from-pink-600 to-rose-600 text-white py-2 px-4 rounded-lg hover:from-pink-700 hover:to-rose-700 transition-all font-semibold">
                        <i class="fas fa-female mr-2"></i>Join Community
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Event Timeline -->
<section class="py-20 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Timeline Events 2025</h2>
            <p class="text-lg text-gray-600">Jadwal lengkap events HASTANA sepanjang tahun</p>
        </div>
        
        <div class="space-y-8">
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="bg-white rounded-xl p-6 shadow-lg ml-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-bold">Q1 2025</h3>
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">Januari - Maret</span>
                    </div>
                    <ul class="space-y-2 text-gray-600">
                        <li>• Workshop Photography Masterclass - Jakarta</li>
                        <li>• Premium Networking Dinner - Surabaya</li>
                        <li>• Business Development Training - Bandung</li>
                        <li>• HASTANA Annual Conference - Bali</li>
                    </ul>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-dot bg-green-600" style="box-shadow: 0 0 0 3px #16a34a;"></div>
                <div class="bg-white rounded-xl p-6 shadow-lg ml-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-bold">Q2 2025</h3>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">April - Juni</span>
                    </div>
                    <ul class="space-y-2 text-gray-600">
                        <li>• Vendor Expo & Exhibition - Jakarta</li>
                        <li>• International Wedding Trends Seminar</li>
                        <li>• Regional Chapter Meetings</li>
                        <li>• Sustainability in Wedding Workshop</li>
                    </ul>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-dot bg-yellow-600" style="box-shadow: 0 0 0 3px #ca8a04;"></div>
                <div class="bg-white rounded-xl p-6 shadow-lg ml-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-bold">Q3 2025</h3>
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">Juli - September</span>
                    </div>
                    <ul class="space-y-2 text-gray-600">
                        <li>• Summer Networking Festival - Bali</li>
                        <li>• Digital Marketing Intensive Course</li>
                        <li>• Young Entrepreneur Workshop</li>
                        <li>• Wedding Planner Certification Program</li>
                    </ul>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-dot bg-red-600" style="box-shadow: 0 0 0 3px #dc2626;"></div>
                <div class="bg-white rounded-xl p-6 shadow-lg ml-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-bold">Q4 2025</h3>
                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">Oktober - Desember</span>
                    </div>
                    <ul class="space-y-2 text-gray-600">
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
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Benefit <span class="bg-gradient-to-r from-blue-600 to-red-600 bg-clip-text text-transparent">Mengikuti Events</span>
            </h2>
            <p class="text-lg text-gray-600">Keuntungan yang Anda dapatkan dari setiap event HASTANA</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-certificate text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Sertifikat Resmi</h3>
                <p class="text-gray-600 text-sm">E-certificate yang diakui industri untuk setiap event yang Anda ikuti</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Premium Networking</h3>
                <p class="text-gray-600 text-sm">Bertemu dengan 500+ wedding organizer profesional dari seluruh Indonesia</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-brain text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Knowledge Update</h3>
                <p class="text-gray-600 text-sm">Update terbaru tentang tren, teknologi, dan best practices industri wedding</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-gift text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Exclusive Perks</h3>
                <p class="text-gray-600 text-sm">Doorprize, merchandise eksklusif, dan special offer dari sponsor</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-red-600 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">
            Siap Bergabung di Event Berikutnya?
        </h2>
        <p class="text-xl mb-8 opacity-90">
            Jangan lewatkan kesempatan untuk networking dan upgrade skill bersama komunitas wedding organizer terbaik Indonesia
        </p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="{{ route('join') }}" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-bold rounded-full hover:bg-gray-100 transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-user-plus mr-3"></i>
                Bergabung HASTANA
            </a>
            <a href="{{ route('contact') }}" class="inline-flex items-center px-8 py-4 border-2 border-white text-white font-bold rounded-full hover:bg-white hover:text-blue-600 transition-all duration-300">
                <i class="fas fa-phone mr-3"></i>
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
