@extends('layouts.app')

@section('title', 'Portfolio Wedding Organizer - HASTANA Indonesia')
@section('description', 'Galeri portfolio terbaik anggota HASTANA Indonesia. Lihat karya-karya spektakuler wedding organizer profesional di seluruh Indonesia.')

@push('styles')
<style>
    .portfolio-card {
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .portfolio-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    
    .portfolio-overlay {
        background: linear-gradient(45deg, rgba(30, 64, 175, 0.9), rgba(220, 38, 38, 0.9));
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .portfolio-card:hover .portfolio-overlay {
        opacity: 1;
    }
    
    .filter-btn {
        transition: all 0.3s ease;
    }
    
    .filter-btn.active {
        background: linear-gradient(135deg, #1e40af, #dc2626);
        color: white;
        transform: scale(1.05);
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-r from-red-900 via-red-800 to-blue-800 py-20 text-white mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                    <i class="fas fa-briefcase text-white text-3xl"></i>
                </div>
            </div>
            
            <h1 class="font-poppins text-4xl md:text-6xl font-bold mb-6 leading-tight">
                Portfolio <span class="text-yellow-300">Wedding Organizer</span>
            </h1>
            
            <p class="text-xl md:text-2xl mb-8 leading-relaxed opacity-90">
                Karya Terbaik Anggota HASTANA Indonesia
            </p>
            
            <div class="text-sm opacity-75">
                Lebih dari 1000+ acara pernikahan telah dipercayakan kepada anggota kami
            </div>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Filter Kategori</h2>
            <p class="text-gray-600">Pilih kategori untuk melihat portfolio spesifik</p>
        </div>
        
        <div class="flex flex-wrap justify-center gap-4">
            <button class="filter-btn active px-6 py-3 rounded-full border-2 border-gray-300 bg-white text-gray-700 font-semibold" data-filter="all">
                Semua Portfolio
            </button>
            <button class="filter-btn px-6 py-3 rounded-full border-2 border-gray-300 bg-white text-gray-700 font-semibold" data-filter="traditional">
                Traditional
            </button>
            <button class="filter-btn px-6 py-3 rounded-full border-2 border-gray-300 bg-white text-gray-700 font-semibold" data-filter="modern">
                Modern
            </button>
            <button class="filter-btn px-6 py-3 rounded-full border-2 border-gray-300 bg-white text-gray-700 font-semibold" data-filter="outdoor">
                Outdoor
            </button>
            <button class="filter-btn px-6 py-3 rounded-full border-2 border-gray-300 bg-white text-gray-700 font-semibold" data-filter="intimate">
                Intimate
            </button>
            <button class="filter-btn px-6 py-3 rounded-full border-2 border-gray-300 bg-white text-gray-700 font-semibold" data-filter="luxury">
                Luxury
            </button>
        </div>
    </div>
</section>

<!-- Portfolio Gallery -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="portfolio-grid">
            
            <!-- Portfolio Item 1 -->
            <div class="portfolio-card bg-white rounded-2xl shadow-lg overflow-hidden" data-category="traditional luxury">
                <div class="relative group">
                    <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=500&h=400&fit=crop" alt="Traditional Wedding" class="w-full h-64 object-cover">
                    <div class="portfolio-overlay absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-xl font-bold mb-2">Traditional Javanese Wedding</h3>
                            <p class="text-sm mb-4">Pernikahan adat Jawa dengan detail sempurna</p>
                            <a href="{{ route('portfolio.detail', 1) }}" class="bg-white text-gray-900 px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition-colors">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm bg-red-100 text-red-800 px-3 py-1 rounded-full">Traditional</span>
                        <span class="text-sm text-gray-500">Jakarta</span>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Elegant Javanese Wedding</h3>
                    <p class="text-gray-600 text-sm mb-4">Wedding organizer: <strong>Prima Wedding</strong></p>
                    <div class="flex justify-between items-center">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-sm text-gray-500">500+ guests</span>
                    </div>
                </div>
            </div>

            <!-- Portfolio Item 2 -->
            <div class="portfolio-card bg-white rounded-2xl shadow-lg overflow-hidden" data-category="modern outdoor">
                <div class="relative group">
                    <img src="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=500&h=400&fit=crop" alt="Modern Outdoor Wedding" class="w-full h-64 object-cover">
                    <div class="portfolio-overlay absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-xl font-bold mb-2">Modern Garden Wedding</h3>
                            <p class="text-sm mb-4">Pernikahan outdoor dengan konsep modern minimalis</p>
                            <a href="{{ route('portfolio.detail', 2) }}" class="bg-white text-gray-900 px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition-colors">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded-full">Modern</span>
                        <span class="text-sm text-gray-500">Bandung</span>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Garden Paradise Wedding</h3>
                    <p class="text-gray-600 text-sm mb-4">Wedding organizer: <strong>Blossom Events</strong></p>
                    <div class="flex justify-between items-center">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-sm text-gray-500">200+ guests</span>
                    </div>
                </div>
            </div>

            <!-- Portfolio Item 3 -->
            <div class="portfolio-card bg-white rounded-2xl shadow-lg overflow-hidden" data-category="intimate modern">
                <div class="relative group">
                    <img src="https://images.unsplash.com/photo-1606800052052-a08af7148866?w=500&h=400&fit=crop" alt="Intimate Wedding" class="w-full h-64 object-cover">
                    <div class="portfolio-overlay absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-xl font-bold mb-2">Intimate Ceremony</h3>
                            <p class="text-sm mb-4">Pernikahan intimate dengan keluarga terdekat</p>
                            <a href="{{ route('portfolio.detail', 3) }}" class="bg-white text-gray-900 px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition-colors">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm bg-green-100 text-green-800 px-3 py-1 rounded-full">Intimate</span>
                        <span class="text-sm text-gray-500">Yogyakarta</span>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Cozy Family Wedding</h3>
                    <p class="text-gray-600 text-sm mb-4">Wedding organizer: <strong>Intimate Moments</strong></p>
                    <div class="flex justify-between items-center">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-sm text-gray-500">50+ guests</span>
                    </div>
                </div>
            </div>

            <!-- Portfolio Item 4 -->
            <div class="portfolio-card bg-white rounded-2xl shadow-lg overflow-hidden" data-category="luxury modern">
                <div class="relative group">
                    <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=500&h=400&fit=crop" alt="Luxury Wedding" class="w-full h-64 object-cover">
                    <div class="portfolio-overlay absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-xl font-bold mb-2">Luxury Hotel Wedding</h3>
                            <p class="text-sm mb-4">Pernikahan mewah di hotel bintang 5</p>
                            <a href="{{ route('portfolio.detail', 4) }}" class="bg-white text-gray-900 px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition-colors">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full">Luxury</span>
                        <span class="text-sm text-gray-500">Surabaya</span>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Grand Ballroom Wedding</h3>
                    <p class="text-gray-600 text-sm mb-4">Wedding organizer: <strong>Luxury Events</strong></p>
                    <div class="flex justify-between items-center">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-sm text-gray-500">800+ guests</span>
                    </div>
                </div>
            </div>

            <!-- Portfolio Item 5 -->
            <div class="portfolio-card bg-white rounded-2xl shadow-lg overflow-hidden" data-category="outdoor traditional">
                <div class="relative group">
                    <img src="https://images.unsplash.com/photo-1545291730-faff8ca1d4b0?w=500&h=400&fit=crop" alt="Beach Wedding" class="w-full h-64 object-cover">
                    <div class="portfolio-overlay absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-xl font-bold mb-2">Beach Wedding Ceremony</h3>
                            <p class="text-sm mb-4">Pernikahan romantis di tepi pantai</p>
                            <a href="{{ route('portfolio.detail', 5) }}" class="bg-white text-gray-900 px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition-colors">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm bg-cyan-100 text-cyan-800 px-3 py-1 rounded-full">Outdoor</span>
                        <span class="text-sm text-gray-500">Bali</span>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Sunset Beach Wedding</h3>
                    <p class="text-gray-600 text-sm mb-4">Wedding organizer: <strong>Tropical Dreams</strong></p>
                    <div class="flex justify-between items-center">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-sm text-gray-500">150+ guests</span>
                    </div>
                </div>
            </div>

            <!-- Portfolio Item 6 -->
            <div class="portfolio-card bg-white rounded-2xl shadow-lg overflow-hidden" data-category="modern luxury">
                <div class="relative group">
                    <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?w=500&h=400&fit=crop" alt="Modern Luxury Wedding" class="w-full h-64 object-cover">
                    <div class="portfolio-overlay absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-xl font-bold mb-2">Contemporary Elegance</h3>
                            <p class="text-sm mb-4">Pernikahan modern dengan sentuhan mewah</p>
                            <a href="{{ route('portfolio.detail', 6) }}" class="bg-white text-gray-900 px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition-colors">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm bg-purple-100 text-purple-800 px-3 py-1 rounded-full">Modern</span>
                        <span class="text-sm text-gray-500">Jakarta</span>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Metropolitan Wedding</h3>
                    <p class="text-gray-600 text-sm mb-4">Wedding organizer: <strong>Urban Celebrations</strong></p>
                    <div class="flex justify-between items-center">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-sm text-gray-500">400+ guests</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Load More Button -->
        <div class="text-center mt-12">
            <button class="bg-gradient-to-r from-blue-600 to-red-600 text-white px-8 py-4 rounded-full font-semibold hover:from-blue-700 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-plus mr-2"></i>
                Muat Lebih Banyak
            </button>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">
            Ingin Menampilkan Portfolio Anda?
        </h2>
        <p class="text-xl mb-8 opacity-90">
            Bergabung dengan HASTANA Indonesia dan tampilkan karya terbaik Anda
        </p>
        <a href="{{ route('join') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-yellow-400 to-yellow-600 text-gray-900 font-bold rounded-full hover:from-yellow-500 hover:to-yellow-700 transition-all duration-300 shadow-lg hover:shadow-xl">
            <i class="fas fa-user-plus mr-3"></i>
            Bergabung Sekarang
        </a>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const portfolioItems = document.querySelectorAll('.portfolio-card');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                
                // Update active button
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Filter portfolio items
                portfolioItems.forEach(item => {
                    const categories = item.getAttribute('data-category');
                    
                    if (filter === 'all' || categories.includes(filter)) {
                        item.style.display = 'block';
                        item.style.animation = 'fadeIn 0.5s ease-in-out';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endpush
