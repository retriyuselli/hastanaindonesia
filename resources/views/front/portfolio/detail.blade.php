@extends('layouts.app')

@section('title', 'Detail Portfolio - HASTANA Indonesia')
@section('description', 'Detail portfolio wedding organizer anggota HASTANA Indonesia.')

@push('styles')
<style>
    .image-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1rem;
    }
    
    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 1rem;
        transition: all 0.3s ease;
    }
    
    .gallery-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    
    .gallery-item img {
        transition: transform 0.5s ease;
    }
    
    .gallery-item:hover img {
        transform: scale(1.05);
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-900 via-purple-800 to-red-900 py-20 text-white mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <div class="mb-8">
                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                    <i class="fas fa-camera text-white text-2xl"></i>
                </div>
            </div>
            
            <h1 class="font-poppins text-3xl md:text-4xl font-bold mb-6 leading-tight">
                Traditional <span class="text-yellow-300">Javanese Wedding</span>
            </h1>
            
            <p class="text-lg md:text-xl mb-8 leading-relaxed opacity-90">
                Pernikahan Adat Jawa dengan Detail Sempurna
            </p>
            
            <div class="flex flex-wrap justify-center gap-4 text-xs opacity-75">
                <span><i class="fas fa-map-marker-alt mr-2"></i>Jakarta</span>
                <span><i class="fas fa-users mr-2"></i>500+ Guests</span>
                <span><i class="fas fa-calendar mr-2"></i>Agustus 2024</span>
                <span><i class="fas fa-crown mr-2"></i>Premium Package</span>
            </div>
        </div>
    </div>
</section>

<!-- Portfolio Details -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Image Gallery -->
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">Gallery Foto</h2>
                    <div class="image-gallery">
                        <div class="gallery-item">
                            <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=600&h=400&fit=crop" 
                                 alt="Traditional Wedding Ceremony" 
                                 class="w-full h-64 object-cover">
                        </div>
                        <div class="gallery-item">
                            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=600&h=400&fit=crop" 
                                 alt="Wedding Decorations" 
                                 class="w-full h-64 object-cover">
                        </div>
                        <div class="gallery-item">
                            <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?w=600&h=400&fit=crop" 
                                 alt="Table Setting" 
                                 class="w-full h-64 object-cover">
                        </div>
                        <div class="gallery-item">
                            <img src="https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=600&h=400&fit=crop" 
                                 alt="Ballroom Setup" 
                                 class="w-full h-64 object-cover">
                        </div>
                        <div class="gallery-item">
                            <img src="https://images.unsplash.com/photo-1606800052052-a08af7148866?w=600&h=400&fit=crop" 
                                 alt="Wedding Details" 
                                 class="w-full h-64 object-cover">
                        </div>
                        <div class="gallery-item">
                            <img src="https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=600&h=400&fit=crop" 
                                 alt="Venue Decoration" 
                                 class="w-full h-64 object-cover">
                        </div>
                    </div>
                </div>
                
                <!-- Description -->
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">Deskripsi Acara</h2>
                    <div class="prose prose-lg text-gray-600 max-w-none">
                        <p class="mb-6">
                            Pernikahan tradisional Jawa yang diselenggarakan dengan penuh kehangatan dan kemegahan. Acara ini menggabungkan nilai-nilai budaya Jawa yang luhur dengan sentuhan modern yang elegan, menciptakan momen yang tak terlupakan bagi kedua mempelai dan seluruh keluarga.
                        </p>
                        
                        <p class="mb-6">
                            Setiap detail acara telah dirancang dengan cermat, mulai dari dekorasi venue yang memadukan ornamen tradisional Jawa dengan bunga-bunga segar pilihan, hingga tata cahaya yang menciptakan suasana sakral dan romantis. Prosesi adat dilaksanakan dengan sempurna, dipandu oleh sesepuh yang berpengalaman.
                        </p>
                        
                        <p class="mb-6">
                            Tim wedding organizer bekerja selama 6 bulan untuk mempersiapkan acara ini, memastikan setiap aspek berjalan dengan lancar. Dari pemilihan venue, koordinasi dengan vendor, hingga manajemen hari H yang melibatkan lebih dari 500 tamu undangan.
                        </p>
                    </div>
                </div>
                
                <!-- Services Included -->
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">Layanan yang Disediakan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-check text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Wedding Planning</h4>
                                <p class="text-gray-600 text-sm">Perencanaan komprehensif dari A sampai Z</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-check text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Venue Decoration</h4>
                                <p class="text-gray-600 text-sm">Dekorasi venue dengan tema tradisional Jawa</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-check text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Catering Management</h4>
                                <p class="text-gray-600 text-sm">Koordinasi dengan catering dan menu planning</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-check text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Photography & Videography</h4>
                                <p class="text-gray-600 text-sm">Dokumentasi professional seluruh acara</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-check text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Entertainment</h4>
                                <p class="text-gray-600 text-sm">Live music dan gamelan tradisional</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-check text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Day Coordination</h4>
                                <p class="text-gray-600 text-sm">Koordinasi penuh di hari pelaksanaan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Wedding Organizer Info -->
                <div class="bg-gray-50 rounded-2xl p-8 mb-8 sticky top-8">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-crown text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Prima Wedding</h3>
                        <p class="text-gray-600 text-sm">Premium Wedding Organizer</p>
                        <div class="flex justify-center text-yellow-400 mt-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span class="text-gray-600 ml-2">(4.9/5)</span>
                        </div>
                    </div>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-map-marker-alt mr-3 text-blue-600"></i>
                            <span>Jakarta Selatan</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-calendar-check mr-3 text-blue-600"></i>
                            <span>200+ Events Completed</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-users mr-3 text-blue-600"></i>
                            <span>HASTANA Premium Member</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-clock mr-3 text-blue-600"></i>
                            <span>8+ Years Experience</span>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <a href="#contact" class="w-full bg-gradient-to-r from-blue-600 to-red-600 text-white py-3 px-4 rounded-full font-semibold text-center flex items-center justify-center hover:from-blue-700 hover:to-red-700 transition-all duration-300">
                            <i class="fas fa-phone mr-2"></i>
                            Hubungi Sekarang
                        </a>
                        <a href="#whatsapp" class="w-full bg-green-500 text-white py-3 px-4 rounded-full font-semibold text-center flex items-center justify-center hover:bg-green-600 transition-all duration-300">
                            <i class="fab fa-whatsapp mr-2"></i>
                            WhatsApp
                        </a>
                    </div>
                </div>
                
                <!-- Project Info -->
                <div class="bg-white border border-gray-200 rounded-2xl p-6">
                    <h4 class="font-bold text-gray-900 mb-4 text-base">Informasi Project</h4>
                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Kategori:</span>
                            <span class="font-medium">Traditional & Luxury</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Durasi Planning:</span>
                            <span class="font-medium">6 Bulan</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jumlah Tamu:</span>
                            <span class="font-medium">500+ Orang</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Venue:</span>
                            <span class="font-medium">Hotel Ballroom</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Budget Range:</span>
                            <span class="font-medium">Premium</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Portfolio -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                Portfolio <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-red-600">Serupa</span>
            </h2>
            <p class="text-base text-gray-600">Portfolio wedding organizer lainnya yang mungkin Anda sukai</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Related Item 1 -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                <div class="aspect-video bg-gray-200">
                    <img src="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=400&h=300&fit=crop" 
                         alt="Modern Garden Wedding" 
                         class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <span class="text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded-full">Modern</span>
                    <h3 class="font-bold text-base mt-3 mb-2">Garden Paradise Wedding</h3>
                    <p class="text-gray-600 text-xs mb-4">Blossom Events • Bandung</p>
                    <a href="{{ route('portfolio.detail', 2) }}" class="text-blue-600 font-semibold text-sm hover:text-blue-700 transition-colors">
                        Lihat Detail →
                    </a>
                </div>
            </div>
            
            <!-- Related Item 2 -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                <div class="aspect-video bg-gray-200">
                    <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=400&h=300&fit=crop" 
                         alt="Luxury Wedding" 
                         class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <span class="text-sm bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full">Luxury</span>
                    <h3 class="font-bold text-base mt-3 mb-2">Grand Ballroom Wedding</h3>
                    <p class="text-gray-600 text-xs mb-4">Luxury Events • Surabaya</p>
                    <a href="{{ route('portfolio.detail', 4) }}" class="text-blue-600 font-semibold text-sm hover:text-blue-700 transition-colors">
                        Lihat Detail →
                    </a>
                </div>
            </div>
            
            <!-- Related Item 3 -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                <div class="aspect-video bg-gray-200">
                    <img src="https://images.unsplash.com/photo-1545291730-faff8ca1d4b0?w=400&h=300&fit=crop" 
                         alt="Beach Wedding" 
                         class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <span class="text-sm bg-cyan-100 text-cyan-800 px-3 py-1 rounded-full">Outdoor</span>
                    <h3 class="font-bold text-base mt-3 mb-2">Sunset Beach Wedding</h3>
                    <p class="text-gray-600 text-xs mb-4">Tropical Dreams • Bali</p>
                    <a href="{{ route('portfolio.detail', 5) }}" class="text-blue-600 font-semibold text-sm hover:text-blue-700 transition-colors">
                        Lihat Detail →
                    </a>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('portfolio') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-gray-800 to-gray-900 text-white font-semibold rounded-full hover:from-gray-900 hover:to-black transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-arrow-left mr-3"></i>
                Kembali ke Portfolio
            </a>
        </div>
    </div>
</section>

@endsection
