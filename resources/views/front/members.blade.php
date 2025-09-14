@extends('layouts.app')

@section('title', 'Daftar Anggota - HASTANA Indonesia')
@section('description', 'Direktori lengkap anggota HASTANA Indonesia. Temukan wedding organizer profesional di seluruh Indonesia.')

@push('styles')
<style>
    .member-card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .member-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        border-color: #3b82f6;
    }
    
    .member-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        z-index: 10;
    }
    
    .search-box {
        transition: all 0.3s ease;
    }
    
    .search-box:focus {
        transform: scale(1.02);
        box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
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
                    <i class="fas fa-users text-white text-3xl"></i>
                </div>
            </div>
            
            <h1 class="font-poppins text-4xl md:text-6xl font-bold mb-6 leading-tight">
                Daftar <span class="text-yellow-300">Anggota</span>
            </h1>
            
            <p class="text-xl md:text-2xl mb-8 leading-relaxed opacity-90">
                Wedding Organizer Profesional di Seluruh Indonesia
            </p>
            
            <div class="text-sm opacity-75">
                125+ anggota aktif siap melayani impian pernikahan Anda
            </div>
        </div>
    </div>
</section>

<!-- Search & Filter Section -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Search -->
                <div class="md:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Anggota</label>
                    <input type="text" placeholder="Nama perusahaan atau kota..." 
                           class="search-box w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <!-- Filter by Region -->
                <div class="md:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Filter Wilayah</label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Semua Wilayah</option>
                        <option>DKI Jakarta</option>
                        <option>Jawa Barat</option>
                        <option>Jawa Tengah</option>
                        <option>Jawa Timur</option>
                        <option>Bali</option>
                        <option>Sumatera</option>
                        <option>Kalimantan</option>
                        <option>Sulawesi</option>
                    </select>
                </div>
                
                <!-- Filter by Membership -->
                <div class="md:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tingkat Keanggotaan</label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Semua Tingkat</option>
                        <option>Platinum</option>
                        <option>Gold</option>
                        <option>Silver</option>
                    </select>
                </div>
                
            </div>
        </div>
    </div>
</section>

<!-- Members Grid -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-xl text-center">
                <div class="text-3xl font-bold">125+</div>
                <div class="text-sm opacity-90">Total Anggota</div>
            </div>
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-xl text-center">
                <div class="text-3xl font-bold">34</div>
                <div class="text-sm opacity-90">Provinsi</div>
            </div>
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-6 rounded-xl text-center">
                <div class="text-3xl font-bold">15+</div>
                <div class="text-sm opacity-90">Tahun Pengalaman</div>
            </div>
            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-xl text-center">
                <div class="text-3xl font-bold">5000+</div>
                <div class="text-sm opacity-90">Event Sukses</div>
            </div>
        </div>

        <!-- Members Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="members-grid">
            
            <!-- Member 1 -->
            <div class="member-card bg-white rounded-2xl shadow-lg overflow-hidden relative">
                <div class="member-badge">
                    <span class="bg-yellow-400 text-gray-900 px-3 py-1 rounded-full text-xs font-bold">PLATINUM</span>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=400&h=250&fit=crop" alt="Prima Wedding" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl mb-2">Prima Wedding Organizer</h3>
                    <p class="text-gray-600 mb-3">
                        <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                        Jakarta Selatan
                    </p>
                    <p class="text-gray-700 text-sm mb-4">
                        Spesialis wedding traditional dan modern dengan pengalaman 15+ tahun. 
                        Telah menangani 500+ pernikahan di seluruh Jakarta.
                    </p>
                    
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span class="text-gray-600 text-sm ml-2">4.9 (127 review)</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Traditional</span>
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Modern</span>
                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs">Luxury</span>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-phone mr-2"></i>Hubungi
                        </button>
                        <button class="flex-1 border border-blue-600 text-blue-600 py-2 px-4 rounded-lg hover:bg-blue-50 transition-colors">
                            <i class="fas fa-eye mr-2"></i>Portfolio
                        </button>
                    </div>
                </div>
            </div>

            <!-- Member 2 -->
            <div class="member-card bg-white rounded-2xl shadow-lg overflow-hidden relative">
                <div class="member-badge">
                    <span class="bg-gray-300 text-gray-900 px-3 py-1 rounded-full text-xs font-bold">GOLD</span>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1606800052052-a08af7148866?w=400&h=250&fit=crop" alt="Blossom Events" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl mb-2">Blossom Events</h3>
                    <p class="text-gray-600 mb-3">
                        <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                        Bandung, Jawa Barat
                    </p>
                    <p class="text-gray-700 text-sm mb-4">
                        Wedding organizer dengan konsep garden dan outdoor wedding. 
                        Menghadirkan suasana romantic untuk momen spesial Anda.
                    </p>
                    
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span class="text-gray-600 text-sm ml-2">4.8 (89 review)</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Outdoor</span>
                        <span class="bg-pink-100 text-pink-800 px-2 py-1 rounded-full text-xs">Garden</span>
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Romantic</span>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-phone mr-2"></i>Hubungi
                        </button>
                        <button class="flex-1 border border-blue-600 text-blue-600 py-2 px-4 rounded-lg hover:bg-blue-50 transition-colors">
                            <i class="fas fa-eye mr-2"></i>Portfolio
                        </button>
                    </div>
                </div>
            </div>

            <!-- Member 3 -->
            <div class="member-card bg-white rounded-2xl shadow-lg overflow-hidden relative">
                <div class="member-badge">
                    <span class="bg-gray-400 text-white px-3 py-1 rounded-full text-xs font-bold">SILVER</span>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=400&h=250&fit=crop" alt="Intimate Moments" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl mb-2">Intimate Moments</h3>
                    <p class="text-gray-600 mb-3">
                        <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                        Yogyakarta
                    </p>
                    <p class="text-gray-700 text-sm mb-4">
                        Spesialis intimate wedding dengan suasana hangat dan personal. 
                        Sempurna untuk pernikahan dengan guest terbatas.
                    </p>
                    
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span class="text-gray-600 text-sm ml-2">4.9 (56 review)</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs">Intimate</span>
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">Cozy</span>
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Personal</span>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-phone mr-2"></i>Hubungi
                        </button>
                        <button class="flex-1 border border-blue-600 text-blue-600 py-2 px-4 rounded-lg hover:bg-blue-50 transition-colors">
                            <i class="fas fa-eye mr-2"></i>Portfolio
                        </button>
                    </div>
                </div>
            </div>

            <!-- Member 4 -->
            <div class="member-card bg-white rounded-2xl shadow-lg overflow-hidden relative">
                <div class="member-badge">
                    <span class="bg-yellow-400 text-gray-900 px-3 py-1 rounded-full text-xs font-bold">PLATINUM</span>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1545291730-faff8ca1d4b0?w=400&h=250&fit=crop" alt="Tropical Dreams" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl mb-2">Tropical Dreams Wedding</h3>
                    <p class="text-gray-600 mb-3">
                        <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                        Denpasar, Bali
                    </p>
                    <p class="text-gray-700 text-sm mb-4">
                        Wedding organizer terbaik di Bali untuk destination wedding. 
                        Spesialis beach wedding dengan pemandangan sunset yang memukau.
                    </p>
                    
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span class="text-gray-600 text-sm ml-2">5.0 (203 review)</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-cyan-100 text-cyan-800 px-2 py-1 rounded-full text-xs">Beach</span>
                        <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs">Tropical</span>
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Destination</span>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-phone mr-2"></i>Hubungi
                        </button>
                        <button class="flex-1 border border-blue-600 text-blue-600 py-2 px-4 rounded-lg hover:bg-blue-50 transition-colors">
                            <i class="fas fa-eye mr-2"></i>Portfolio
                        </button>
                    </div>
                </div>
            </div>

            <!-- Member 5 -->
            <div class="member-card bg-white rounded-2xl shadow-lg overflow-hidden relative">
                <div class="member-badge">
                    <span class="bg-gray-300 text-gray-900 px-3 py-1 rounded-full text-xs font-bold">GOLD</span>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?w=400&h=250&fit=crop" alt="Urban Celebrations" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl mb-2">Urban Celebrations</h3>
                    <p class="text-gray-600 mb-3">
                        <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                        Surabaya, Jawa Timur
                    </p>
                    <p class="text-gray-700 text-sm mb-4">
                        Modern metropolitan wedding dengan konsep contemporary. 
                        Menghadirkan nuansa urban yang elegant dan sophisticated.
                    </p>
                    
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span class="text-gray-600 text-sm ml-2">4.7 (94 review)</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">Urban</span>
                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs">Modern</span>
                        <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full text-xs">Contemporary</span>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-phone mr-2"></i>Hubungi
                        </button>
                        <button class="flex-1 border border-blue-600 text-blue-600 py-2 px-4 rounded-lg hover:bg-blue-50 transition-colors">
                            <i class="fas fa-eye mr-2"></i>Portfolio
                        </button>
                    </div>
                </div>
            </div>

            <!-- Member 6 -->
            <div class="member-card bg-white rounded-2xl shadow-lg overflow-hidden relative">
                <div class="member-badge">
                    <span class="bg-gray-400 text-white px-3 py-1 rounded-full text-xs font-bold">SILVER</span>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=400&h=250&fit=crop" alt="Luxury Events" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl mb-2">Luxury Events Indonesia</h3>
                    <p class="text-gray-600 mb-3">
                        <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                        Jakarta Pusat
                    </p>
                    <p class="text-gray-700 text-sm mb-4">
                        Spesialis luxury wedding dengan detail yang sempurna. 
                        Menangani high-end wedding untuk klien eksekutif dan selebritis.
                    </p>
                    
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span class="text-gray-600 text-sm ml-2">4.8 (112 review)</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">Luxury</span>
                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs">High-end</span>
                        <span class="bg-pink-100 text-pink-800 px-2 py-1 rounded-full text-xs">Exclusive</span>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-phone mr-2"></i>Hubungi
                        </button>
                        <button class="flex-1 border border-blue-600 text-blue-600 py-2 px-4 rounded-lg hover:bg-blue-50 transition-colors">
                            <i class="fas fa-eye mr-2"></i>Portfolio
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-12">
            <nav class="flex space-x-2">
                <button class="px-4 py-2 bg-gray-200 text-gray-600 rounded-lg hover:bg-gray-300">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">1</button>
                <button class="px-4 py-2 bg-gray-200 text-gray-600 rounded-lg hover:bg-gray-300">2</button>
                <button class="px-4 py-2 bg-gray-200 text-gray-600 rounded-lg hover:bg-gray-300">3</button>
                <button class="px-4 py-2 bg-gray-200 text-gray-600 rounded-lg hover:bg-gray-300">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </nav>
        </div>

    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-red-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">
            Bergabunglah dengan Komunitas Professional
        </h2>
        <p class="text-xl mb-8 opacity-90">
            Jadilah bagian dari HASTANA Indonesia dan kembangkan bisnis wedding organizer Anda
        </p>
        <a href="{{ route('join') }}" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-bold rounded-full hover:bg-gray-100 transition-all duration-300 shadow-lg hover:shadow-xl">
            <i class="fas fa-user-plus mr-3"></i>
            Daftar Jadi Anggota
        </a>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchBox = document.querySelector('.search-box');
        const memberCards = document.querySelectorAll('.member-card');

        searchBox.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            memberCards.forEach(card => {
                const companyName = card.querySelector('h3').textContent.toLowerCase();
                const location = card.querySelector('.fa-map-marker-alt').parentElement.textContent.toLowerCase();
                
                if (companyName.includes(searchTerm) || location.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush
