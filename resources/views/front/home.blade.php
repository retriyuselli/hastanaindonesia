@extends('layouts.app')

@section('title', 'HASTANA Indonesia - Himpunan Perusahaan Penata Acara Seluruh Indonesia')
@section('description', 'Organisasi resmi yang menaungi para wedding organizer profesional di Indonesia. Mendukung profesionalisme dan kolaborasi WO di seluruh Indonesia.')

@push('styles')
<style>
    /* Custom Hastana Styles */
    .hero-bg {
        background: linear-gradient(135deg, rgba(26, 26, 26, 0.7), rgba(30, 64, 175, 0.6), rgba(220, 38, 38, 0.5)),
                   url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><defs><pattern id="wedding-pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="20" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/><circle cx="50" cy="50" r="10" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23wedding-pattern)"/></svg>');
        background-size: cover, 100px 100px;
        background-position: center, 0 0;
        background-attachment: fixed;
    }
    
    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .card-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
    
    .gradient-text {
        background: linear-gradient(135deg, #1e40af, #dc2626);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .text-hastana-blue { color: #1e40af; }
    .text-hastana-red { color: #dc2626; }
    .bg-hastana-blue { background-color: #1e40af; }
    .bg-hastana-red { background-color: #dc2626; }
    .border-hastana-blue { border-color: #1e40af; }
    
    .floating-animation {
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    .portfolio-grid img {
        transition: all 0.3s ease;
    }
    
    .portfolio-grid img:hover {
        transform: scale(1.05);
        filter: brightness(1.1);
    }
    
    .portfolio-card {
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .portfolio-overlay {
        transition: all 0.3s ease;
    }
    
    /* Portfolio Marquee Animation */
    @keyframes scroll-left {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-50%);
        }
    }
    
    .portfolio-marquee {
        display: flex;
        overflow: hidden;
        width: 100%;
    }
    
    .portfolio-marquee-content {
        display: flex;
        animation: scroll-left 30s linear infinite;
        gap: 1.5rem;
    }
    
    .portfolio-marquee:hover .portfolio-marquee-content {
        animation-play-state: paused;
    }
    
    .portfolio-marquee-item {
        flex: 0 0 300px;
        min-width: 300px;
    }
    
    /* Gallery Styles */
    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .gallery-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    
    .gallery-item img {
        transition: transform 0.5s ease;
    }
    
    .gallery-item:hover img {
        transform: scale(1.1);
    }
    
    .gallery-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 1rem;
    }
    
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-bg min-h-screen flex items-center justify-center relative overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
        <div class="floating-animation">
            <div class="mb-8">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-red-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl">
                    <i class="fas fa-gem text-white text-3xl"></i>
                </div>
            </div>
            
            <h1 class="font-poppins text-3xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                <span class="block">HASTANA</span>
                <span class="block text-xl md:text-2xl lg:text-3xl font-medium mt-2 text-gray-200">
                    Himpunan Perusahaan Penata Acara Seluruh Indonesia
                </span>
            </h1>
            
            <p class="text-lg md:text-xl mb-10 max-w-4xl mx-auto leading-relaxed text-gray-100">
                Mendukung Profesionalisme Wedding Organizer di Seluruh Indonesia
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('members') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-semibold rounded-full hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                    <i class="fas fa-users mr-2 text-xs"></i>
                    Lihat Daftar Anggota
                </a>
                <a href="{{ route('join') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white text-sm font-semibold rounded-full hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                    <i class="fas fa-handshake mr-2 text-xs"></i>
                    Gabung Bersama Kami
                </a>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white">
        <div class="animate-bounce">
            <i class="fas fa-chevron-down text-2xl"></i>
        </div>
    </div>
</section>

<!-- Highlights Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Mengapa <span class="gradient-text">HASTANA</span>?
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Organisasi yang berkomitmen memajukan industri wedding organizer Indonesia
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Profesionalisme -->
            <div class="card-hover bg-white p-6 rounded-2xl shadow-lg text-center">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-certificate text-white text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3">Profesionalisme</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Standar kualitas tinggi dengan sertifikasi resmi untuk semua anggota wedding organizer
                </p>
            </div>
            
            <!-- Kolaborasi WO -->
            <div class="card-hover bg-white p-6 rounded-2xl shadow-lg text-center">
                <div class="w-14 h-14 bg-gradient-to-br from-red-600 to-red-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-handshake text-white text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3">Kolaborasi WO</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Platform kolaborasi antar wedding organizer untuk saling berbagi pengalaman dan best practices
                </p>
            </div>
            
            <!-- Jaringan Nasional -->
            <div class="card-hover bg-white p-6 rounded-2xl shadow-lg text-center">
                <div class="w-14 h-14 bg-gradient-to-br from-gray-700 to-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-globe-asia text-white text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3">Jaringan Nasional</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Jaringan wedding organizer terluas di Indonesia dengan coverage di seluruh nusantara
                </p>
            </div>
            
            <!-- Event & Pelatihan -->
            <div class="card-hover bg-white p-6 rounded-2xl shadow-lg text-center">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-graduation-cap text-white text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3">Event & Pelatihan</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Program pelatihan berkelanjutan dan event networking untuk pengembangan skill profesional
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Tentang Hastana Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    Tentang <span class="gradient-text">HASTANA</span>
                </h2>
                <div class="prose text-gray-600 leading-relaxed space-y-4">
                    <p>
                        <strong>Himpunan Perusahaan Penata Acara Seluruh Indonesia (HASTANA)</strong> adalah organisasi resmi yang menaungi para wedding organizer profesional di seluruh Indonesia. Kami berkomitmen untuk meningkatkan standar kualitas industri pernikahan Indonesia melalui sertifikasi, pelatihan, dan kolaborasi antar profesional.
                    </p>
                    <p>
                        Dengan jaringan yang tersebar di berbagai kota besar Indonesia, HASTANA menjadi wadah bagi para wedding organizer untuk saling berbagi pengalaman, mengembangkan skill, dan memberikan pelayanan terbaik bagi pasangan yang ingin merayakan hari istimewa mereka.
                    </p>
                    <p>
                        Misi kami adalah menciptakan ekosistem wedding organizer yang profesional, terpercaya, dan inovatif, sehingap setiap pernikahan di Indonesia dapat diselenggarakan dengan standar internasional.
                    </p>
                </div>
                
                <div class="mt-8 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('about') }}" class="inline-flex items-center px-5 py-2.5 border-2 border-hastana-blue text-hastana-blue font-semibold text-sm rounded-full hover:bg-hastana-blue hover:text-white transition-all duration-300">
                        <i class="fas fa-info-circle mr-2 text-xs"></i>
                        Selengkapnya
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-5 py-2.5 text-gray-600 font-semibold text-sm hover:text-hastana-blue transition-colors duration-300">
                        <i class="fas fa-envelope mr-2 text-xs"></i>
                        Hubungi Kami
                    </a>
                </div>
            </div>
            
            <div class="relative">
                <div class="aspect-square bg-gradient-to-br from-blue-100 to-red-100 rounded-3xl flex items-center justify-center">
                    <div class="text-center">
                        <div class="w-28 h-28 bg-gradient-to-br from-blue-600 to-red-600 rounded-full flex items-center justify-center mx-auto mb-5">
                            <i class="fas fa-heart text-white text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">1000+</h3>
                        <p class="text-sm text-gray-600 font-medium">Wedding Organizer Tersertifikasi</p>
                    </div>
                </div>
                <!-- Decorative elements -->
                <div class="absolute -top-4 -right-4 w-20 h-20 bg-blue-200 rounded-full opacity-20"></div>
                <div class="absolute -bottom-4 -left-4 w-28 h-28 bg-red-200 rounded-full opacity-20"></div>
            </div>
        </div>
    </div>
</section>

<!-- Portfolio WO Preview -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Portfolio <span class="gradient-text">Wedding Organizer</span>
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto mb-6">
                Karya terbaik dari anggota HASTANA yang telah mewujudkan ribuan pernikahan impian
            </p>
        </div>
    </div>
    
    <!-- Full width marquee container -->
    <div class="w-full">
        <div class="portfolio-marquee mb-10">
            <div class="portfolio-marquee-content">
                @forelse($featuredPortfolios as $portfolio)
                <!-- Portfolio Item {{ $loop->iteration }} -->
                <div class="portfolio-marquee-item">
                    <a href="{{ url('/portfolio/detail/' . $portfolio->id) }}" class="block h-full">
                    <div class="portfolio-card bg-white rounded-2xl shadow-lg overflow-hidden h-full cursor-pointer">
                <div class="relative group">
                    @if($portfolio->first_image)
                        <img src="{{ asset('storage/' . $portfolio->first_image) }}" 
                             alt="{{ $portfolio->title }}" 
                             class="w-full h-64 object-cover">
                    @else
                        <div class="w-full h-64 bg-gradient-to-br from-pink-200 to-rose-300 flex items-center justify-center">
                            <i class="fas fa-image text-3xl text-white opacity-50"></i>
                        </div>
                    @endif
                    <div class="portfolio-overlay absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-900/90 to-red-900/90 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="text-center text-white px-4">
                            <h3 class="text-lg font-bold mb-2">{{ $portfolio->title }}</h3>
                            <p class="text-sm mb-4">{{ Str::limit($portfolio->description, 60) }}</p>
                            <span class="bg-white text-gray-900 px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition-colors inline-block">
                                Lihat Detail
                            </span>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-center mb-3">
                        @if($portfolio->category)
                            <span class="text-xs bg-blue-100 text-blue-800 px-3 py-1 rounded-full">{{ $portfolio->category }}</span>
                        @else
                            <span class="text-xs bg-gray-100 text-gray-800 px-3 py-1 rounded-full">Wedding</span>
                        @endif
                        <span class="text-xs text-gray-500">{{ $portfolio->location ?? 'Indonesia' }}</span>
                    </div>
                    <h3 class="font-bold text-sm mb-2">{{ $portfolio->title }}</h3>
                    <p class="text-gray-600 text-xs mb-3">by <strong>{{ $portfolio->weddingOrganizer->name ?? 'Wedding Organizer' }}</strong></p>
                    <div class="flex justify-between items-center">
                        <div class="flex text-yellow-400 text-xs">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-xs text-gray-500"><i class="fas fa-heart mr-1"></i>{{ $portfolio->views ?? 0 }}</span>
                    </div>
                </div>
                    </div>
                    </a>
                </div>
                @empty
            <!-- Default Portfolio Items when no data -->
            <!-- Portfolio Item 1 -->
            <div class="portfolio-marquee-item">
                <div class="portfolio-card bg-white rounded-2xl shadow-lg overflow-hidden h-full">
                <div class="relative group">
                    <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=400&h=400&fit=crop" 
                         alt="Wedding Tradisional Jawa" 
                         class="w-full h-64 object-cover"
                         loading="lazy">
                    <div class="portfolio-overlay absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-900/90 to-red-900/90 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="text-center text-white px-4">
                            <h3 class="text-lg font-bold mb-2">Traditional Javanese Wedding</h3>
                            <p class="text-sm mb-4">Pernikahan adat Jawa dengan detail sempurna</p>
                            <a href="{{ route('portfolio') }}" class="bg-white text-gray-900 px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition-colors inline-block">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-xs bg-red-100 text-red-800 px-3 py-1 rounded-full">Traditional</span>
                        <span class="text-xs text-gray-500">Jakarta</span>
                    </div>
                    <h3 class="font-bold text-sm mb-2">Elegant Javanese Wedding</h3>
                    <p class="text-gray-600 text-xs mb-3">by <strong>Prima Wedding</strong></p>
                    <div class="flex justify-between items-center">
                        <div class="flex text-yellow-400 text-xs">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-xs text-gray-500"><i class="fas fa-heart mr-1"></i>234</span>
                    </div>
                </div>
                </div>
            </div>
            
            <!-- Portfolio Item 2 -->
            <div class="portfolio-marquee-item">
                <div class="portfolio-card bg-white rounded-2xl shadow-lg overflow-hidden h-full">
                <div class="relative group">
                    <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=400&h=400&fit=crop" 
                         alt="Modern Minimalist Wedding" 
                         class="w-full h-64 object-cover"
                         loading="lazy">
                    <div class="portfolio-overlay absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-900/90 to-red-900/90 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="text-center text-white px-4">
                            <h3 class="text-lg font-bold mb-2">Modern Minimalist Wedding</h3>
                            <p class="text-sm mb-4">Konsep pernikahan modern dengan dekorasi minimalis</p>
                            <a href="{{ route('portfolio') }}" class="bg-white text-gray-900 px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition-colors inline-block">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-xs bg-purple-100 text-purple-800 px-3 py-1 rounded-full">Modern</span>
                        <span class="text-xs text-gray-500">Bandung</span>
                    </div>
                    <h3 class="font-bold text-sm mb-2">Modern Minimalist Wedding</h3>
                    <p class="text-gray-600 text-xs mb-3">by <strong>Modern Wedding Planner</strong></p>
                    <div class="flex justify-between items-center">
                        <div class="flex text-yellow-400 text-xs">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-xs text-gray-500"><i class="fas fa-heart mr-1"></i>189</span>
                    </div>
                </div>
                </div>
            </div>
            
            <!-- Portfolio Item 3 -->
            <div class="portfolio-marquee-item">
                <div class="portfolio-card bg-white rounded-2xl shadow-lg overflow-hidden h-full">
                <div class="relative group">
                    <img src="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=400&h=400&fit=crop" 
                         alt="Garden Wedding Outdoor" 
                         class="w-full h-64 object-cover"
                         loading="lazy">
                    <div class="portfolio-overlay absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-900/90 to-red-900/90 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="text-center text-white px-4">
                            <h3 class="text-lg font-bold mb-2">Garden Wedding</h3>
                            <p class="text-sm mb-4">Pernikahan outdoor di taman dengan suasana natural</p>
                            <a href="{{ route('portfolio') }}" class="bg-white text-gray-900 px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition-colors inline-block">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-xs bg-green-100 text-green-800 px-3 py-1 rounded-full">Outdoor</span>
                        <span class="text-xs text-gray-500">Bali</span>
                    </div>
                    <h3 class="font-bold text-sm mb-2">Garden Wedding Outdoor</h3>
                    <p class="text-gray-600 text-xs mb-3">by <strong>Bali Dream Wedding</strong></p>
                    <div class="flex justify-between items-center">
                        <div class="flex text-yellow-400 text-xs">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-xs text-gray-500"><i class="fas fa-heart mr-1"></i>312</span>
                    </div>
                </div>
                </div>
            </div>
            
            <!-- Portfolio Item 4 -->
            <div class="portfolio-marquee-item">
                <div class="portfolio-card bg-white rounded-2xl shadow-lg overflow-hidden h-full">
                <div class="relative group">
                    <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=400&h=400&fit=crop" 
                         alt="Luxury Ballroom Wedding" 
                         class="w-full h-64 object-cover"
                         loading="lazy">
                    <div class="portfolio-overlay absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-900/90 to-red-900/90 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="text-center text-white px-4">
                            <h3 class="text-lg font-bold mb-2">Luxury Ballroom</h3>
                            <p class="text-sm mb-4">Resepsi mewah di ballroom hotel bintang lima</p>
                            <a href="{{ route('portfolio') }}" class="bg-white text-gray-900 px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition-colors inline-block">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-xs bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full">Luxury</span>
                        <span class="text-xs text-gray-500">Surabaya</span>
                    </div>
                    <h3 class="font-bold text-sm mb-2">Luxury Ballroom Wedding</h3>
                    <p class="text-gray-600 text-xs mb-3">by <strong>Elite Wedding Organizer</strong></p>
                    <div class="flex justify-between items-center">
                        <div class="flex text-yellow-400 text-xs">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-xs text-gray-500"><i class="fas fa-heart mr-1"></i>278</span>
                    </div>
                </div>
                </div>
            </div>
            @endforelse
            
            <!-- Duplicate cards for seamless loop -->
            @forelse($featuredPortfolios as $portfolio)
            <div class="portfolio-marquee-item">
                    <a href="{{ url('/portfolio/detail/' . $portfolio->id) }}" class="block h-full">
                    <div class="portfolio-card bg-white rounded-2xl shadow-lg overflow-hidden h-full cursor-pointer">
                        <div class="relative group">
                            @if($portfolio->first_image)
                                <img src="{{ asset('storage/' . $portfolio->first_image) }}" 
                                     alt="{{ $portfolio->title }}" 
                                     class="w-full h-64 object-cover">
                            @else
                                <div class="w-full h-64 bg-gradient-to-br from-pink-200 to-rose-300 flex items-center justify-center">
                                    <i class="fas fa-image text-3xl text-white opacity-50"></i>
                                </div>
                            @endif
                            <div class="portfolio-overlay absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-900/90 to-red-900/90 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="text-center text-white px-4">
                                    <h3 class="text-lg font-bold mb-2">{{ $portfolio->title }}</h3>
                                    <p class="text-sm mb-4">{{ Str::limit($portfolio->description, 60) }}</p>
                                    <span class="bg-white text-gray-900 px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition-colors inline-block">
                                        Lihat Detail
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-3">
                                @if($portfolio->category)
                                    <span class="text-xs bg-blue-100 text-blue-800 px-3 py-1 rounded-full">{{ $portfolio->category }}</span>
                                @else
                                    <span class="text-xs bg-gray-100 text-gray-800 px-3 py-1 rounded-full">Wedding</span>
                                @endif
                                <span class="text-xs text-gray-500">{{ $portfolio->location ?? 'Indonesia' }}</span>
                            </div>
                            <h3 class="font-bold text-sm mb-2">{{ $portfolio->title }}</h3>
                            <p class="text-gray-600 text-xs mb-3">by <strong>{{ $portfolio->weddingOrganizer->name ?? 'Wedding Organizer' }}</strong></p>
                            <div class="flex justify-between items-center">
                                <div class="flex text-yellow-400 text-xs">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-xs text-gray-500"><i class="fas fa-heart mr-1"></i>{{ $portfolio->views ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                @empty
                <!-- Duplicate fallback items -->
                @for($i = 0; $i < 4; $i++)
                <div class="portfolio-marquee-item">
                    <div class="portfolio-card bg-white rounded-2xl shadow-lg overflow-hidden h-full">
                        <div class="relative group">
                            <img src="https://images.unsplash.com/photo-{{ ['1519741497674-611481863552', '1519225421980-715cb0215aed', '1464366400600-7168b8af9bc3', '1511285560929-80b456fea0bc'][$i] }}?w=400&h=400&fit=crop" 
                                 alt="Portfolio Item" 
                                 class="w-full h-64 object-cover"
                                 loading="lazy">
                            <div class="portfolio-overlay absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-900/90 to-red-900/90 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="text-center text-white px-4">
                                    <h3 class="text-lg font-bold mb-2">{{ ['Traditional Javanese Wedding', 'Modern Minimalist Wedding', 'Garden Wedding', 'Luxury Ballroom'][$i] }}</h3>
                                    <p class="text-sm mb-4">{{ ['Pernikahan adat Jawa dengan detail sempurna', 'Konsep pernikahan modern dengan dekorasi minimalis', 'Pernikahan outdoor di taman dengan suasana natural', 'Resepsi mewah di ballroom hotel bintang lima'][$i] }}</p>
                                    <a href="{{ route('portfolio') }}" class="bg-white text-gray-900 px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition-colors inline-block">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-xs bg-{{ ['red', 'purple', 'green', 'yellow'][$i] }}-100 text-{{ ['red', 'purple', 'green', 'yellow'][$i] }}-800 px-3 py-1 rounded-full">{{ ['Traditional', 'Modern', 'Outdoor', 'Luxury'][$i] }}</span>
                                <span class="text-xs text-gray-500">{{ ['Jakarta', 'Bandung', 'Bali', 'Surabaya'][$i] }}</span>
                            </div>
                            <h3 class="font-bold text-sm mb-2">{{ ['Elegant Javanese Wedding', 'Modern Minimalist Wedding', 'Garden Wedding Outdoor', 'Luxury Ballroom Wedding'][$i] }}</h3>
                            <p class="text-gray-600 text-xs mb-3">by <strong>{{ ['Prima Wedding', 'Modern Wedding Planner', 'Bali Dream Wedding', 'Elite Wedding Organizer'][$i] }}</strong></p>
                            <div class="flex justify-between items-center">
                                <div class="flex text-yellow-400 text-xs">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-xs text-gray-500"><i class="fas fa-heart mr-1"></i>{{ [234, 189, 312, 278][$i] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
                @endforelse
            
            <!-- Duplicate cards for seamless loop (2nd set) -->
            @forelse($featuredPortfolios as $portfolio)
            <div class="portfolio-marquee-item">
                    <a href="{{ url('/portfolio/detail/' . $portfolio->id) }}" class="block h-full">
                    <div class="portfolio-card bg-white rounded-2xl shadow-lg overflow-hidden h-full cursor-pointer">
                        <div class="relative group">
                            @if($portfolio->first_image)
                                <img src="{{ asset('storage/' . $portfolio->first_image) }}" 
                                     alt="{{ $portfolio->title }}" 
                                     class="w-full h-64 object-cover">
                            @else
                                <div class="w-full h-64 bg-gradient-to-br from-pink-200 to-rose-300 flex items-center justify-center">
                                    <i class="fas fa-image text-3xl text-white opacity-50"></i>
                                </div>
                            @endif
                            <div class="portfolio-overlay absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-900/90 to-red-900/90 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="text-center text-white px-4">
                                    <h3 class="text-lg font-bold mb-2">{{ $portfolio->title }}</h3>
                                    <p class="text-sm mb-4">{{ Str::limit($portfolio->description, 60) }}</p>
                                    <span class="bg-white text-gray-900 px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition-colors inline-block">
                                        Lihat Detail
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-3">
                                @if($portfolio->category)
                                    <span class="text-xs bg-blue-100 text-blue-800 px-3 py-1 rounded-full">{{ $portfolio->category }}</span>
                                @else
                                    <span class="text-xs bg-gray-100 text-gray-800 px-3 py-1 rounded-full">Wedding</span>
                                @endif
                                <span class="text-xs text-gray-500">{{ $portfolio->location ?? 'Indonesia' }}</span>
                            </div>
                            <h3 class="font-bold text-sm mb-2">{{ $portfolio->title }}</h3>
                            <p class="text-gray-600 text-xs mb-3">by <strong>{{ $portfolio->weddingOrganizer->name ?? 'Wedding Organizer' }}</strong></p>
                            <div class="flex justify-between items-center">
                                <div class="flex text-yellow-400 text-xs">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-xs text-gray-500"><i class="fas fa-heart mr-1"></i>{{ $portfolio->views ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                @empty
                <!-- Duplicate fallback items (2nd set) -->
                @for($i = 0; $i < 4; $i++)
                <div class="portfolio-marquee-item">
                    <div class="portfolio-card bg-white rounded-2xl shadow-lg overflow-hidden h-full">
                        <div class="relative group">
                            <img src="https://images.unsplash.com/photo-{{ ['1519741497674-611481863552', '1519225421980-715cb0215aed', '1464366400600-7168b8af9bc3', '1511285560929-80b456fea0bc'][$i] }}?w=400&h=400&fit=crop" 
                                 alt="Portfolio Item" 
                                 class="w-full h-64 object-cover"
                                 loading="lazy">
                            <div class="portfolio-overlay absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-900/90 to-red-900/90 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="text-center text-white px-4">
                                    <h3 class="text-lg font-bold mb-2">{{ ['Traditional Javanese Wedding', 'Modern Minimalist Wedding', 'Garden Wedding', 'Luxury Ballroom'][$i] }}</h3>
                                    <p class="text-sm mb-4">{{ ['Pernikahan adat Jawa dengan detail sempurna', 'Konsep pernikahan modern dengan dekorasi minimalis', 'Pernikahan outdoor di taman dengan suasana natural', 'Resepsi mewah di ballroom hotel bintang lima'][$i] }}</p>
                                    <a href="{{ route('portfolio') }}" class="bg-white text-gray-900 px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition-colors inline-block">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-xs bg-{{ ['red', 'purple', 'green', 'yellow'][$i] }}-100 text-{{ ['red', 'purple', 'green', 'yellow'][$i] }}-800 px-3 py-1 rounded-full">{{ ['Traditional', 'Modern', 'Outdoor', 'Luxury'][$i] }}</span>
                                <span class="text-xs text-gray-500">{{ ['Jakarta', 'Bandung', 'Bali', 'Surabaya'][$i] }}</span>
                            </div>
                            <h3 class="font-bold text-sm mb-2">{{ ['Elegant Javanese Wedding', 'Modern Minimalist Wedding', 'Garden Wedding Outdoor', 'Luxury Ballroom Wedding'][$i] }}</h3>
                            <p class="text-gray-600 text-xs mb-3">by <strong>{{ ['Prima Wedding', 'Modern Wedding Planner', 'Bali Dream Wedding', 'Elite Wedding Organizer'][$i] }}</strong></p>
                            <div class="flex justify-between items-center">
                                <div class="flex text-yellow-400 text-xs">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-xs text-gray-500"><i class="fas fa-heart mr-1"></i>{{ [234, 189, 312, 278][$i] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
                @endforelse
            </div>
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mt-10">
            <a href="{{ route('portfolio') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-red-600 text-white font-semibold text-sm rounded-full hover:from-blue-700 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-images mr-2 text-xs"></i>
                Lihat Semua Portfolio
            </a>
        </div>
    </div>
</section>

<!-- Daftar Anggota WO Preview -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Anggota <span class="gradient-text">Wedding Organizer</span>
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Wedding organizer terpercaya dan bersertifikat HASTANA
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Member 1 -->
            <div class="card-hover bg-white p-5 rounded-2xl shadow-lg border border-gray-100 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-crown text-white text-xl"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-1">Elegant Wedding Organizer</h3>
                <p class="text-xs text-gray-600 mb-1">Jakarta Selatan</p>
                <p class="text-xs text-blue-600 font-medium">Premium Member</p>
                <div class="mt-3 flex justify-center space-x-1">
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                </div>
            </div>
            
            <!-- Member 2 -->
            <div class="card-hover bg-white p-5 rounded-2xl shadow-lg border border-gray-100 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-heart text-white text-xl"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-1">Bali Dream Wedding</h3>
                <p class="text-xs text-gray-600 mb-1">Bali</p>
                <p class="text-xs text-red-600 font-medium">Gold Member</p>
                <div class="mt-3 flex justify-center space-x-1">
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                </div>
            </div>
            
            <!-- Member 3 -->
            <div class="card-hover bg-white p-5 rounded-2xl shadow-lg border border-gray-100 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-gem text-white text-xl"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-1">Surabaya Modern Wedding</h3>
                <p class="text-xs text-gray-600 mb-1">Surabaya</p>
                <p class="text-xs text-purple-600 font-medium">Silver Member</p>
                <div class="mt-3 flex justify-center space-x-1">
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                    <i class="fas fa-star text-gray-300 text-xs"></i>
                </div>
            </div>
            
            <!-- Member 4 -->
            <div class="card-hover bg-white p-5 rounded-2xl shadow-lg border border-gray-100 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-leaf text-white text-xl"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-1">Yogya Traditional Event</h3>
                <p class="text-xs text-gray-600 mb-1">Yogyakarta</p>
                <p class="text-xs text-green-600 font-medium">Silver Member</p>
                <div class="mt-3 flex justify-center space-x-1">
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                    <i class="fas fa-star text-gray-300 text-xs"></i>
                </div>
            </div>
        </div>
        
        <div class="text-center">
            <a href="#members" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-800 to-gray-900 text-white font-semibold text-sm rounded-full hover:from-gray-900 hover:to-black transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-users mr-2 text-xs"></i>
                Lihat Semua Anggota
            </a>
        </div>
    </div>
</section>

<!-- Event Terbaru -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Event <span class="gradient-text">Terbaru</span>
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Ikuti berbagai event dan pelatihan untuk mengembangkan skill professional Anda
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
            <!-- Event 1 -->
            <div class="card-hover bg-white rounded-2xl overflow-hidden shadow-lg">
                <div class="aspect-video overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1606491956689-2ea866880c84?w=600&h=337&fit=crop" 
                         alt="Workshop fotografi pernikahan dengan kamera profesional" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                         loading="lazy">
                </div>
                <div class="p-6">
                    <div class="flex items-center text-xs text-gray-500 mb-2">
                        <i class="fas fa-calendar mr-1.5"></i>
                        <span>25 Agustus 2025</span>
                        <i class="fas fa-map-marker-alt ml-3 mr-1.5"></i>
                        <span>Jakarta</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Workshop Fotografi Pernikahan Modern</h3>
                    <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                        Pelatihan intensif fotografi pernikahan dengan teknik modern dan equipment terbaru. Dipandu oleh fotografer profesional dengan pengalaman internasional.
                    </p>
                    <a href="#events" class="inline-flex items-center text-blue-600 font-semibold text-sm hover:text-blue-700 transition-colors">
                        Daftar Sekarang
                        <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>
            
            <!-- Event 2 -->
            <div class="card-hover bg-white rounded-2xl overflow-hidden shadow-lg">
                <div class="aspect-video overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1511632765486-a01980e01a18?w=600&h=337&fit=crop" 
                         alt="Networking event dan gala dinner untuk profesional" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                         loading="lazy">
                </div>
                <div class="p-6">
                    <div class="flex items-center text-xs text-gray-500 mb-2">
                        <i class="fas fa-calendar mr-1.5"></i>
                        <span>2 September 2025</span>
                        <i class="fas fa-map-marker-alt ml-3 mr-1.5"></i>
                        <span>Bali</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">HASTANA Annual Networking Gala</h3>
                    <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                        Acara networking tahunan HASTANA yang mempertemukan wedding organizer dari seluruh Indonesia. Kesempatan emas untuk membangun relasi profesional.
                    </p>
                    <a href="#events" class="inline-flex items-center text-red-600 font-semibold text-sm hover:text-red-700 transition-colors">
                        Daftar Sekarang
                        <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="text-center">
            <a href="#events" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-semibold text-sm rounded-full hover:from-purple-700 hover:to-purple-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-calendar-check mr-2 text-xs"></i>
                Lihat Semua Event
            </a>
        </div>
    </div>
</section>

<!-- Highlight Artikel/Blog -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Artikel & <span class="gradient-text">Insights</span>
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Tips, tren, dan insights terbaru dari dunia wedding organizer Indonesia
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Article 1 -->
            <div class="card-hover bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100">
                <div class="aspect-video overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=400&h=225&fit=crop" 
                         alt="Sustainable Wedding - Eco-friendly decoration" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                         loading="lazy">
                </div>
                <div class="p-5">
                    <div class="text-xs text-gray-500 mb-2">15 Agustus 2025</div>
                    <h3 class="text-base font-bold text-gray-900 mb-2">Tren Pernikahan 2025: Sustainable Wedding</h3>
                    <p class="text-xs text-gray-600 leading-relaxed mb-3">
                        Eksplorasi tren pernikahan ramah lingkungan yang semakin populer di kalangan milenial Indonesia...
                    </p>
                    <a href="#blog" class="text-blue-600 font-semibold text-xs hover:text-blue-700 transition-colors">
                        Baca Selengkapnya →
                    </a>
                </div>
            </div>
            
            <!-- Article 2 -->
            <div class="card-hover bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100">
                <div class="aspect-video overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=400&h=225&fit=crop" 
                         alt="Wedding budget planning and calculation" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                         loading="lazy">
                </div>
                <div class="p-5">
                    <div class="text-xs text-gray-500 mb-2">12 Agustus 2025</div>
                    <h3 class="text-base font-bold text-gray-900 mb-2">Tips Manajemen Budget Wedding yang Efektif</h3>
                    <p class="text-xs text-gray-600 leading-relaxed mb-3">
                        Strategi jitu untuk wedding organizer dalam membantu klien mengelola budget pernikahan...
                    </p>
                    <a href="#blog" class="text-blue-600 font-semibold text-xs hover:text-blue-700 transition-colors">
                        Baca Selengkapnya →
                    </a>
                </div>
            </div>
            
            <!-- Article 3 -->
            <div class="card-hover bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100">
                <div class="aspect-video overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&h=225&fit=crop" 
                         alt="Digital marketing analytics and social media" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                         loading="lazy">
                </div>
                <div class="p-5">
                    <div class="text-xs text-gray-500 mb-2">10 Agustus 2025</div>
                    <h3 class="text-base font-bold text-gray-900 mb-2">Digital Marketing untuk Wedding Organizer</h3>
                    <p class="text-xs text-gray-600 leading-relaxed mb-3">
                        Panduan lengkap memanfaatkan media sosial dan digital marketing untuk bisnis wedding organizer...
                    </p>
                    <a href="#blog" class="text-blue-600 font-semibold text-xs hover:text-blue-700 transition-colors">
                        Baca Selengkapnya →
                    </a>
                </div>
            </div>
        </div>
        
        <div class="text-center">
            <a href="#blog" class="inline-flex items-center px-6 py-3 border-2 border-gray-800 text-gray-800 font-semibold text-sm rounded-full hover:bg-gray-800 hover:text-white transition-all duration-300">
                <i class="fas fa-blog mr-2 text-xs"></i>
                Lihat Semua Artikel
            </a>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="flex items-center justify-center mb-5">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-red-500 rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-images text-white text-xl"></i>
                </div>
            </div>
            
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Gallery <span class="gradient-text">HASTANA INDONESIA</span>
            </h2>
            
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Momen-momen terbaik dan karya menawan dari anggota wedding organizer HASTANA Indonesia
            </p>
        </div>

        <!-- Photo Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Gallery Item 1 -->
            <div class="gallery-item relative group cursor-pointer overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="aspect-square bg-gray-200 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=400&h=400&fit=crop" 
                         alt="Setup ballroom untuk resepsi mewah" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                         loading="lazy">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h4 class="font-semibold text-sm mb-1">Setup Ballroom Mewah</h4>
                        <p class="text-xs opacity-90">Dekorasi ballroom untuk resepsi pernikahan</p>
                    </div>
                    <div class="absolute top-4 right-4">
                        <i class="fas fa-search-plus text-white text-lg opacity-80"></i>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 2 -->
            <div class="gallery-item relative group cursor-pointer overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="aspect-square bg-gray-200 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=400&h=400&fit=crop" 
                         alt="Akad nikah tradisional Indonesia" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                         loading="lazy">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h4 class="font-semibold text-sm mb-1">Akad Nikah Tradisional</h4>
                        <p class="text-xs opacity-90">Upacara akad nikah yang khidmat</p>
                    </div>
                    <div class="absolute top-4 right-4">
                        <i class="fas fa-search-plus text-white text-lg opacity-80"></i>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 3 -->
            <div class="gallery-item relative group cursor-pointer overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="aspect-square bg-gray-200 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=400&h=400&fit=crop" 
                         alt="Garden wedding outdoor ceremony" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                         loading="lazy">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h4 class="font-semibold text-sm mb-1">Garden Wedding</h4>
                        <p class="text-xs opacity-90">Pernikahan outdoor di taman yang indah</p>
                    </div>
                    <div class="absolute top-4 right-4">
                        <i class="fas fa-search-plus text-white text-lg opacity-80"></i>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 4 -->
            <div class="gallery-item relative group cursor-pointer overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="aspect-square bg-gray-200 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1606800052052-a08af7148866?w=400&h=400&fit=crop" 
                         alt="Wedding decoration setup behind the scenes" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                         loading="lazy">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h4 class="font-semibold text-sm mb-1">Behind The Scenes</h4>
                        <p class="text-xs opacity-90">Proses persiapan dekorasi pernikahan</p>
                    </div>
                    <div class="absolute top-4 right-4">
                        <i class="fas fa-search-plus text-white text-lg opacity-80"></i>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 5 -->
            <div class="gallery-item relative group cursor-pointer overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="aspect-square bg-gray-200 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?w=400&h=400&fit=crop" 
                         alt="Elegant wedding table setting" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                         loading="lazy">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h4 class="font-semibold text-sm mb-1">Table Setting Elegan</h4>
                        <p class="text-xs opacity-90">Penataan meja untuk perjamuan</p>
                    </div>
                    <div class="absolute top-4 right-4">
                        <i class="fas fa-search-plus text-white text-lg opacity-80"></i>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 6 -->
            <div class="gallery-item relative group cursor-pointer overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="aspect-square bg-gray-200 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=400&h=400&fit=crop" 
                         alt="Traditional Indonesian wedding attire" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                         loading="lazy">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h4 class="font-semibold text-sm mb-1">Busana Tradisional</h4>
                        <p class="text-xs opacity-90">Pengantin dengan busana adat Indonesia</p>
                    </div>
                    <div class="absolute top-4 right-4">
                        <i class="fas fa-search-plus text-white text-lg opacity-80"></i>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 7 -->
            <div class="gallery-item relative group cursor-pointer overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="aspect-square bg-gray-200 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?w=400&h=400&fit=crop" 
                         alt="Wedding planning consultation" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                         loading="lazy">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h4 class="font-semibold text-sm mb-1">Konsultasi Pernikahan</h4>
                        <p class="text-xs opacity-90">Sesi planning dengan wedding organizer</p>
                    </div>
                    <div class="absolute top-4 right-4">
                        <i class="fas fa-search-plus text-white text-lg opacity-80"></i>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 8 -->
            <div class="gallery-item relative group cursor-pointer overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="aspect-square bg-gray-200 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=400&h=400&fit=crop" 
                         alt="Wedding venue decoration" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                         loading="lazy">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h4 class="font-semibold text-sm mb-1">Dekorasi Venue</h4>
                        <p class="text-xs opacity-90">Setup dekorasi venue pernikahan</p>
                    </div>
                    <div class="absolute top-4 right-4">
                        <i class="fas fa-search-plus text-white text-lg opacity-80"></i>
                    </div>
                </div>
            </div>

        </div>
        
        <!-- CTA Button -->
        <div class="text-center mt-12">
            <a href="{{ route('gallery') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-red-600 text-white font-bold text-sm rounded-full hover:from-blue-700 hover:to-red-700 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                <i class="fas fa-images mr-2 text-xs"></i>
                Lihat Gallery Lengkap
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-gray-900 via-blue-900 to-red-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-5">
            Siap Bergabung dengan <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-red-400">HASTANA</span>?
        </h2>
        <p class="text-lg text-gray-200 mb-8 leading-relaxed">
            Tingkatkan profesionalisme dan kembangkan bisnis wedding organizer Anda bersama komunitas terbaik Indonesia
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="#join" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold text-sm rounded-full hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                <i class="fas fa-user-plus mr-2 text-xs"></i>
                Daftar Keanggotaan
            </a>
            <a href="#contact" class="inline-flex items-center px-6 py-3 border-2 border-white text-white font-bold text-sm rounded-full hover:bg-white hover:text-gray-900 transition-all duration-300">
                <i class="fas fa-phone mr-2 text-xs"></i>
                Konsultasi Gratis
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Smooth scrolling for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
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
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);

    // Observe all cards for animation
    document.querySelectorAll('.card-hover').forEach(card => {
        observer.observe(card);
    });

    // Instagram posts click handler
    document.querySelectorAll('[data-instagram-post]').forEach(post => {
        post.addEventListener('click', function() {
            const postUrl = this.getAttribute('data-instagram-url');
            if (postUrl) {
                window.open(postUrl, '_blank');
            }
        });
    });

    // Instagram feed animation
    const instagramObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.instagram-post').forEach(post => {
        post.style.opacity = '0';
        post.style.transform = 'translateY(20px)';
        post.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        instagramObserver.observe(post);
    });
</script>
@endpush
