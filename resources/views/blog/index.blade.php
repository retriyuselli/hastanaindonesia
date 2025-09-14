@extends('layouts.app')

@section('title', 'Blog - HASTANA Indonesia')
@section('description', 'Blog dan artikel terbaru dari HASTANA Indonesia. Tips wedding organizer, tren pernikahan, dan panduan bisnis WO.')

@push('styles')
<style>
    .blog-card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .blog-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        border-color: #3b82f6;
    }
    
    .category-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
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
    
    .featured-post {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(220, 38, 38, 0.1));
        border: 2px solid #3b82f6;
    }
    
    .read-time {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: #6b7280;
    }
    
    .author-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .post-stats {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.875rem;
        color: #6b7280;
    }
    
    .trending-badge {
        background: linear-gradient(45deg, #ff6b6b, #feca57);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: bold;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }
    
    .search-box {
        position: relative;
    }
    
    .search-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        max-height: 200px;
        overflow-y: auto;
        z-index: 20;
        display: none;
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
                    <i class="fas fa-blog text-white text-3xl"></i>
                </div>
            </div>
            
            <h1 class="font-poppins text-4xl md:text-6xl font-bold mb-6 leading-tight">
                Blog & <span class="text-yellow-300">Artikel</span>
            </h1>
            
            <p class="text-xl md:text-2xl mb-8 leading-relaxed opacity-90">
                Tips, Tren, dan Panduan untuk Wedding Organizer Profesional
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <div class="bg-white/20 backdrop-blur-sm rounded-full px-6 py-3">
                    <span class="text-sm font-semibold">📝 100+ Artikel</span>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-full px-6 py-3">
                    <span class="text-sm font-semibold">👥 Expert Contributors</span>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-full px-6 py-3">
                    <span class="text-sm font-semibold">🔄 Update Mingguan</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search & Filter Section -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search Bar -->
        <div class="max-w-2xl mx-auto mb-8">
            <div class="search-box">
                <div class="relative">
                    <input type="text" 
                           id="searchInput"
                           placeholder="Cari artikel, tips, atau topik..." 
                           class="w-full px-6 py-4 pl-12 bg-white border border-gray-300 rounded-full shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <div class="search-results" id="searchResults">
                    <!-- Search results will appear here -->
                </div>
            </div>
        </div>
        
        <!-- Filter Tabs -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Kategori Artikel</h2>
            <p class="text-gray-600 mb-6">Pilih kategori sesuai minat Anda</p>
        </div>
        
        <div class="flex flex-wrap justify-center gap-4">
            <button class="filter-tab active px-6 py-3 rounded-full border-2 border-gray-300 bg-white text-gray-700 font-semibold" data-filter="all">
                Semua Artikel
            </button>
            <button class="filter-tab px-6 py-3 rounded-full border-2 border-gray-300 bg-white text-gray-700 font-semibold" data-filter="trending">
                Trending
            </button>
            <button class="filter-tab px-6 py-3 rounded-full border-2 border-gray-300 bg-white text-gray-700 font-semibold" data-filter="tips">
                Tips & Tricks
            </button>
            <button class="filter-tab px-6 py-3 rounded-full border-2 border-gray-300 bg-white text-gray-700 font-semibold" data-filter="business">
                Business
            </button>
            <button class="filter-tab px-6 py-3 rounded-full border-2 border-gray-300 bg-white text-gray-700 font-semibold" data-filter="trends">
                Wedding Trends
            </button>
            <button class="filter-tab px-6 py-3 rounded-full border-2 border-gray-300 bg-white text-gray-700 font-semibold" data-filter="technology">
                Technology
            </button>
        </div>
    </div>
</section>

<!-- Featured Article -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Artikel <span class="bg-gradient-to-r from-blue-600 to-red-600 bg-clip-text text-transparent">Unggulan</span>
            </h2>
        </div>
        
        <div class="blog-card featured-post bg-white rounded-2xl shadow-xl overflow-hidden" data-category="trending business">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=600&h=400&fit=crop&auto=format" alt="Digital Wedding Transformation" class="w-full h-64 lg:h-full object-cover">
                    <div class="category-badge">
                        <span class="trending-badge">🔥 TRENDING</span>
                    </div>
                </div>
                <div class="p-8 lg:p-12">
                    <div class="flex items-center gap-4 mb-4">
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">Business</span>
                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">Technology</span>
                    </div>
                    
                    <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4 leading-tight">
                        Digital Transformation dalam Industri Wedding Organizer 2025
                    </h3>
                    
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Bagaimana teknologi AI, Virtual Reality, dan platform digital mengubah cara wedding organizer 
                        bekerja dan berinteraksi dengan klien. Panduan lengkap untuk adaptasi digital.
                    </p>
                    
                    <div class="flex items-center justify-between mb-6">
                        <div class="author-info">
                            <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?w=40&h=40&fit=crop&crop=face&auto=format" alt="Sarah Putri" class="w-10 h-10 rounded-full">
                            <div>
                                <div class="font-semibold text-gray-900">Sarah Putri</div>
                                <div class="text-sm text-gray-500">Digital Strategy Expert</div>
                            </div>
                        </div>
                        <div class="read-time">
                            <i class="fas fa-clock text-gray-400"></i>
                            <span>15 min read</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="post-stats">
                            <span><i class="fas fa-eye mr-1"></i>2.5K views</span>
                            <span><i class="fas fa-heart mr-1"></i>89 likes</span>
                            <span><i class="fas fa-comment mr-1"></i>23 comments</span>
                        </div>
                        <button class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-full hover:from-blue-700 hover:to-blue-800 transition-all font-semibold" onclick="window.location.href='{{ route('blog.detail', ['slug' => 'digital-transformation-wedding-organizer-2025']) }}'">
                            Baca Selengkapnya
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Grid -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Artikel Terbaru</h2>
            <p class="text-lg text-gray-600">Update terbaru dari dunia wedding organizer</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="blog-grid">
            
            <!-- Article 1 -->
            <div class="blog-card bg-white rounded-2xl shadow-lg overflow-hidden relative" data-category="tips trending">
                <div class="category-badge">
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">TIPS</span>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=400&h=250&fit=crop&auto=format" alt="Wedding Budget Tips" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">Tips</span>
                        <span class="text-sm text-gray-500">5 Jan 2025</span>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-3">10 Tips Mengelola Budget Wedding untuk Klien</h3>
                    <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                        Strategi jitu untuk membantu klien mengoptimalkan budget pernikahan tanpa mengurangi kualitas. 
                        Include template budget planner gratis!
                    </p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div class="author-info">
                            <img src="https://images.unsplash.com/photo-1566492031773-4f4e44671d66?w=32&h=32&fit=crop&crop=face&auto=format" alt="Budi Santoso" class="w-8 h-8 rounded-full">
                            <span class="text-sm font-semibold">Budi Santoso</span>
                        </div>
                        <div class="read-time">
                            <i class="fas fa-clock text-gray-400"></i>
                            <span>8 min</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="post-stats">
                            <span><i class="fas fa-eye mr-1 text-gray-400"></i>1.2K</span>
                            <span><i class="fas fa-heart mr-1 text-red-400"></i>45</span>
                        </div>
                        <a href="{{ route('blog.detail', ['slug' => 'tips-mengelola-budget-wedding-klien']) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                            Baca →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Article 2 -->
            <div class="blog-card bg-white rounded-2xl shadow-lg overflow-hidden relative" data-category="trends">
                <div class="category-badge">
                    <span class="bg-purple-500 text-white px-3 py-1 rounded-full text-xs font-bold">TRENDS</span>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1469371670807-013ccf25f16a?w=400&h=250&fit=crop&auto=format" alt="Wedding Trends 2025" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">Trends</span>
                        <span class="text-sm text-gray-500">3 Jan 2025</span>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Tren Pernikahan 2025: Sustainable Wedding</h3>
                    <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                        Eco-friendly wedding menjadi tren utama 2025. Panduan lengkap mengorganisir pernikahan ramah lingkungan 
                        yang tetap mewah dan berkesan.
                    </p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div class="author-info">
                            <img src="https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?w=32&h=32&fit=crop&crop=face&auto=format" alt="Maya Sari" class="w-8 h-8 rounded-full">
                            <span class="text-sm font-semibold">Maya Sari</span>
                        </div>
                        <div class="read-time">
                            <i class="fas fa-clock text-gray-400"></i>
                            <span>12 min</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="post-stats">
                            <span><i class="fas fa-eye mr-1 text-gray-400"></i>890</span>
                            <span><i class="fas fa-heart mr-1 text-red-400"></i>67</span>
                        </div>
                        <a href="{{ route('blog.detail', ['slug' => 'tren-pernikahan-2025-sustainable-wedding']) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                            Baca →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Article 3 -->
            <div class="blog-card bg-white rounded-2xl shadow-lg overflow-hidden relative" data-category="business">
                <div class="category-badge">
                    <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-bold">BUSINESS</span>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=400&h=250&fit=crop&auto=format" alt="Marketing Strategy" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">Business</span>
                        <span class="text-sm text-gray-500">1 Jan 2025</span>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Strategi Marketing Digital untuk WO Pemula</h3>
                    <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                        Panduan step-by-step membangun presence digital yang kuat untuk wedding organizer. 
                        Dari social media hingga website optimization.
                    </p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div class="author-info">
                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=32&h=32&fit=crop&crop=face&auto=format" alt="Andi Wijaya" class="w-8 h-8 rounded-full">
                            <span class="text-sm font-semibold">Andi Wijaya</span>
                        </div>
                        <div class="read-time">
                            <i class="fas fa-clock text-gray-400"></i>
                            <span>20 min</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="post-stats">
                            <span><i class="fas fa-eye mr-1 text-gray-400"></i>1.5K</span>
                            <span><i class="fas fa-heart mr-1 text-red-400"></i>78</span>
                        </div>
                        <a href="{{ route('blog.detail', ['slug' => 'strategi-marketing-digital-wo-pemula']) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                            Baca →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Article 4 -->
            <div class="blog-card bg-white rounded-2xl shadow-lg overflow-hidden relative" data-category="technology">
                <div class="category-badge">
                    <span class="bg-indigo-500 text-white px-3 py-1 rounded-full text-xs font-bold">TECH</span>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&h=250&fit=crop&auto=format" alt="Wedding Technology" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm">Technology</span>
                        <span class="text-sm text-gray-500">28 Dec 2024</span>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-3">5 Aplikasi Wajib untuk Wedding Organizer</h3>
                    <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                        Tools digital yang dapat meningkatkan efisiensi kerja dan memberikan pengalaman terbaik untuk klien. 
                        Review lengkap dan comparison.
                    </p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div class="author-info">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=32&h=32&fit=crop&crop=face&auto=format" alt="Lisa Chen" class="w-8 h-8 rounded-full">
                            <span class="text-sm font-semibold">Lisa Chen</span>
                        </div>
                        <div class="read-time">
                            <i class="fas fa-clock text-gray-400"></i>
                            <span>10 min</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="post-stats">
                            <span><i class="fas fa-eye mr-1 text-gray-400"></i>980</span>
                            <span><i class="fas fa-heart mr-1 text-red-400"></i>52</span>
                        </div>
                        <a href="{{ route('blog.detail', ['slug' => '5-aplikasi-wajib-wedding-organizer']) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                            Baca →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Article 5 -->
            <div class="blog-card bg-white rounded-2xl shadow-lg overflow-hidden relative" data-category="tips">
                <div class="category-badge">
                    <span class="bg-yellow-500 text-gray-900 px-3 py-1 rounded-full text-xs font-bold">TIPS</span>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?w=400&h=250&fit=crop&auto=format" alt="Client Management" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">Tips</span>
                        <span class="text-sm text-gray-500">25 Dec 2024</span>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Cara Menangani Klien yang Sulit</h3>
                    <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                        Strategi komunikasi dan manajemen ekspektasi untuk menghadapi berbagai tipe klien. 
                        Tips dari WO berpengalaman.
                    </p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div class="author-info">
                            <img src="https://images.unsplash.com/photo-1507591064344-4c6ce005b128?w=32&h=32&fit=crop&crop=face&auto=format" alt="Rudi Hartono" class="w-8 h-8 rounded-full">
                            <span class="text-sm font-semibold">Rudi Hartono</span>
                        </div>
                        <div class="read-time">
                            <i class="fas fa-clock text-gray-400"></i>
                            <span>7 min</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="post-stats">
                            <span><i class="fas fa-eye mr-1 text-gray-400"></i>1.1K</span>
                            <span><i class="fas fa-heart mr-1 text-red-400"></i>89</span>
                        </div>
                        <a href="{{ route('blog.detail', ['slug' => 'cara-menangani-klien-yang-sulit']) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                            Baca →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Article 6 -->
            <div class="blog-card bg-white rounded-2xl shadow-lg overflow-hidden relative" data-category="business trends">
                <div class="category-badge">
                    <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">HOT</span>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=400&h=250&fit=crop&auto=format" alt="Wedding Business Trends" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">Business</span>
                        <span class="text-sm text-gray-500">22 Dec 2024</span>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Peluang Bisnis WO di Era Post-Pandemic</h3>
                    <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                        Analisis market wedding organizer pasca pandemi dan strategi adaptasi untuk pertumbuhan bisnis 
                        yang sustainable.
                    </p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div class="author-info">
                            <img src="https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=32&h=32&fit=crop&crop=face&auto=format" alt="Sari Dewi" class="w-8 h-8 rounded-full">
                            <span class="text-sm font-semibold">Sari Dewi</span>
                        </div>
                        <div class="read-time">
                            <i class="fas fa-clock text-gray-400"></i>
                            <span>18 min</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="post-stats">
                            <span><i class="fas fa-eye mr-1 text-gray-400"></i>2.1K</span>
                            <span><i class="fas fa-heart mr-1 text-red-400"></i>95</span>
                        </div>
                        <a href="{{ route('blog.detail', ['slug' => 'peluang-bisnis-wo-era-post-pandemic']) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                            Baca →
                        </a>
                    </div>
                </div>
            </div>

        </div>
        
        <!-- Load More Button -->
        <div class="text-center mt-12">
            <button class="bg-gradient-to-r from-blue-600 to-red-600 text-white px-8 py-4 rounded-full hover:from-blue-700 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold">
                <i class="fas fa-plus mr-2"></i>Load More Articles
            </button>
        </div>
    </div>
</section>

<!-- Newsletter Subscription -->
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-gradient-to-r from-blue-50 to-red-50 rounded-3xl p-8 lg:p-12">
            <div class="mb-6">
                <i class="fas fa-envelope text-4xl text-blue-600 mb-4"></i>
            </div>
            
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Subscribe Newsletter
            </h2>
            <p class="text-lg text-gray-600 mb-8">
                Dapatkan artikel terbaru, tips eksklusif, dan update industri wedding organizer langsung di inbox Anda
            </p>
            
            <div class="max-w-md mx-auto">
                <div class="flex gap-4">
                    <input type="email" 
                           placeholder="Masukkan email Anda..." 
                           class="flex-1 px-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <button class="bg-gradient-to-r from-blue-600 to-red-600 text-white px-6 py-3 rounded-full hover:from-blue-700 hover:to-red-700 transition-all font-semibold whitespace-nowrap">
                        Subscribe
                    </button>
                </div>
                <p class="text-sm text-gray-500 mt-3">*Gratis dan bisa unsubscribe kapan saja</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-red-600 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">
            Ingin Berbagi Pengalaman?
        </h2>
        <p class="text-xl mb-8 opacity-90">
            Jadi contributor blog HASTANA dan bagikan expertise Anda dengan komunitas wedding organizer Indonesia
        </p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="{{ route('contact') }}" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-bold rounded-full hover:bg-gray-100 transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-pen mr-3"></i>
                Jadi Contributor
            </a>
            <a href="{{ route('join') }}" class="inline-flex items-center px-8 py-4 border-2 border-white text-white font-bold rounded-full hover:bg-white hover:text-blue-600 transition-all duration-300">
                <i class="fas fa-user-plus mr-3"></i>
                Bergabung HASTANA
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
        const blogCards = document.querySelectorAll('.blog-card');

        filterTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                
                // Update active tab
                filterTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                // Filter articles
                blogCards.forEach(card => {
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

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');

        const sampleSearchData = [
            'Tips Mengelola Budget Wedding',
            'Tren Pernikahan 2025',
            'Strategi Marketing Digital',
            'Aplikasi untuk Wedding Organizer',
            'Cara Menangani Klien',
            'Peluang Bisnis WO'
        ];

        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            
            if (query.length > 2) {
                const filteredResults = sampleSearchData.filter(item => 
                    item.toLowerCase().includes(query)
                );
                
                if (filteredResults.length > 0) {
                    searchResults.innerHTML = filteredResults
                        .map(item => `<div class="px-4 py-2 hover:bg-gray-100 cursor-pointer">${item}</div>`)
                        .join('');
                    searchResults.style.display = 'block';
                } else {
                    searchResults.style.display = 'none';
                }
            } else {
                searchResults.style.display = 'none';
            }
        });

        // Hide search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.style.display = 'none';
            }
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

        // Observe blog cards
        blogCards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
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
