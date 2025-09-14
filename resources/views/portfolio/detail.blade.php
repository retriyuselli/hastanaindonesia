@extends('layouts.app')

@section('title', 'Detail Portfolio - HASTANA Indonesia')
@section('description', 'Detail portfolio wedding organizer HASTANA Indonesia. Lihat galeri foto, vendor, dan detail lengkap acara pernikahan.')

@push('styles')
<style>
    .gallery-item {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .gallery-item:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    
    .vendor-card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .vendor-card:hover {
        border-color: #3b82f6;
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .timeline-item {
        position: relative;
        padding-left: 3rem;
        margin-bottom: 2rem;
    }
    
    .timeline-item:before {
        content: '';
        position: absolute;
        left: 1rem;
        top: 0;
        bottom: -2rem;
        width: 2px;
        background: linear-gradient(to bottom, #3b82f6, #dc2626);
    }
    
    .timeline-item:last-child:before {
        bottom: 0;
    }
    
    .timeline-dot {
        position: absolute;
        left: 0.5rem;
        top: 0.5rem;
        width: 1rem;
        height: 1rem;
        background: #3b82f6;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 0 0 3px #3b82f6;
    }
    
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.9);
    }
    
    .modal-content {
        position: relative;
        margin: auto;
        padding: 0;
        max-width: 90%;
        max-height: 90%;
        top: 50%;
        transform: translateY(-50%);
    }
    
    .modal img {
        width: 100%;
        height: auto;
        max-height: 90vh;
        object-fit: contain;
    }
    
    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
        z-index: 1001;
    }
    
    .close:hover {
        color: #bbb;
    }
    
    .prev, .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        padding: 16px;
        margin-top: -50px;
        color: white;
        font-weight: bold;
        font-size: 20px;
        background: rgba(0,0,0,0.5);
        border: none;
        user-select: none;
        transition: 0.3s ease;
    }
    
    .next {
        right: 0;
        border-radius: 3px 0 0 3px;
    }
    
    .prev {
        left: 0;
        border-radius: 0 3px 3px 0;
    }
    
    .prev:hover, .next:hover {
        background: rgba(0,0,0,0.8);
    }
    
    .floating-nav {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        z-index: 100;
    }
    
    .nav-item {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .testimonial-card {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(220, 38, 38, 0.1));
        border-left: 4px solid #3b82f6;
    }
</style>
@endpush

@section('content')

<!-- Hero Section with Portfolio Images -->
<section class="relative h-screen overflow-hidden">
    <div class="absolute inset-0">
        <div class="grid grid-cols-3 h-full">
            <div class="relative overflow-hidden">
                <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=800&h=1200&fit=crop" alt="Wedding Photo 1" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
            </div>
            <div class="relative overflow-hidden">
                <img src="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=800&h=1200&fit=crop" alt="Wedding Photo 2" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
            </div>
            <div class="relative overflow-hidden">
                <img src="https://images.unsplash.com/photo-1606800052052-a08af7148866?w=800&h=1200&fit=crop" alt="Wedding Photo 3" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
            </div>
        </div>
    </div>
    
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/70 flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
            <div class="max-w-4xl">
                <div class="mb-6">
                    <a href="{{ route('portfolio') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Portfolio
                    </a>
                </div>
                
                <div class="mb-8">
                    <span class="bg-gradient-to-r from-blue-600 to-red-600 text-white px-4 py-2 rounded-full text-sm font-semibold">
                        Traditional Luxury Wedding
                    </span>
                </div>
                
                <h1 class="font-poppins text-4xl md:text-6xl font-bold mb-6 leading-tight">
                    Elegant <span class="text-yellow-300">Javanese Wedding</span>
                </h1>
                
                <p class="text-xl md:text-2xl mb-8 leading-relaxed opacity-90">
                    Pernikahan adat Jawa yang memukau dengan detail tradisional yang sempurna
                </p>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold">500+</div>
                        <div class="text-sm opacity-80">Guests</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold">2 Days</div>
                        <div class="text-sm opacity-80">Event</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold">15</div>
                        <div class="text-sm opacity-80">Vendors</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold">Jakarta</div>
                        <div class="text-sm opacity-80">Location</div>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-4">
                    <button onclick="scrollToSection('gallery')" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-full hover:from-blue-700 hover:to-blue-800 transition-all font-semibold">
                        <i class="fas fa-images mr-2"></i>Lihat Galeri
                    </button>
                    <button onclick="scrollToSection('vendors')" class="border-2 border-white text-white px-6 py-3 rounded-full hover:bg-white hover:text-gray-900 transition-all font-semibold">
                        <i class="fas fa-users mr-2"></i>Vendor List
                    </button>
                    <button onclick="scrollToSection('timeline')" class="border-2 border-white text-white px-6 py-3 rounded-full hover:bg-white hover:text-gray-900 transition-all font-semibold">
                        <i class="fas fa-calendar mr-2"></i>Timeline
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Wedding Organizer Info -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-center">
            <div class="lg:col-span-2">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Tentang <span class="bg-gradient-to-r from-blue-600 to-red-600 bg-clip-text text-transparent">Wedding Organizer</span>
                    </h2>
                    <div class="w-20 h-1 bg-gradient-to-r from-blue-600 to-red-600 rounded-full"></div>
                </div>
                
                <div class="prose prose-lg text-gray-600">
                    <p class="mb-6">
                        <strong>Prima Wedding</strong> adalah wedding organizer profesional yang telah berpengalaman lebih dari 10 tahun 
                        dalam menyelenggarakan pernikahan tradisional Jawa. Kami mengkhususkan diri dalam memadukan nilai-nilai 
                        tradisional dengan sentuhan modern yang elegan.
                    </p>
                    
                    <p class="mb-6">
                        Tim kami terdiri dari para ahli yang memahami betul filosofi dan tata cara pernikahan adat Jawa, 
                        mulai dari prosesi lamaran, siraman, midodareni, hingga resepsi. Setiap detail diperhatikan dengan 
                        seksama untuk memastikan momen spesial Anda berjalan sempurna.
                    </p>
                    
                    <div class="grid grid-cols-2 gap-6 mt-8">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Keahlian Khusus</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Pernikahan Adat Jawa</li>
                                <li>• Dekorasi Traditional</li>
                                <li>• Koordinasi Prosesi</li>
                                <li>• Manajemen Vendor</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Pencapaian</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• 200+ Wedding Sukses</li>
                                <li>• Best WO Award 2023</li>
                                <li>• 5 Star Rating</li>
                                <li>• Member HASTANA</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="lg:col-span-1">
                <div class="bg-gradient-to-br from-blue-50 to-red-50 rounded-2xl p-8">
                    <div class="text-center mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-600 to-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-award text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Prima Wedding</h3>
                        <p class="text-gray-600">Traditional Wedding Specialist</p>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Rating</span>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="text-gray-600 ml-2">5.0</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Pengalaman</span>
                            <span class="font-semibold">10+ Tahun</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Projects</span>
                            <span class="font-semibold">200+ Wedding</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Lokasi</span>
                            <span class="font-semibold">Jakarta, Indonesia</span>
                        </div>
                    </div>
                    
                    <div class="mt-8 space-y-3">
                        <a href="{{ route('contact') }}" class="block w-full bg-gradient-to-r from-blue-600 to-red-600 text-white py-3 rounded-full text-center font-semibold hover:from-blue-700 hover:to-red-700 transition-all">
                            <i class="fas fa-phone mr-2"></i>Konsultasi Gratis
                        </a>
                        <button class="block w-full border-2 border-blue-600 text-blue-600 py-3 rounded-full text-center font-semibold hover:bg-blue-50 transition-all">
                            <i class="fas fa-heart mr-2"></i>Simpan Favorit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Photo Gallery -->
<section id="gallery" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Galeri <span class="bg-gradient-to-r from-blue-600 to-red-600 bg-clip-text text-transparent">Foto</span>
            </h2>
            <p class="text-lg text-gray-600">Momen-momen indah dalam pernikahan adat Jawa</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Gallery Images -->
            <div class="gallery-item rounded-xl overflow-hidden" onclick="openModal(this.querySelector('img').src)">
                <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=400&h=300&fit=crop" alt="Akad Nikah" class="w-full h-48 object-cover">
            </div>
            <div class="gallery-item rounded-xl overflow-hidden" onclick="openModal(this.querySelector('img').src)">
                <img src="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=400&h=300&fit=crop" alt="Prosesi Siraman" class="w-full h-48 object-cover">
            </div>
            <div class="gallery-item rounded-xl overflow-hidden" onclick="openModal(this.querySelector('img').src)">
                <img src="https://images.unsplash.com/photo-1606800052052-a08af7148866?w=400&h=300&fit=crop" alt="Midodareni" class="w-full h-48 object-cover">
            </div>
            <div class="gallery-item rounded-xl overflow-hidden" onclick="openModal(this.querySelector('img').src)">
                <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=400&h=300&fit=crop" alt="Resepsi" class="w-full h-48 object-cover">
            </div>
            <div class="gallery-item rounded-xl overflow-hidden" onclick="openModal(this.querySelector('img').src)">
                <img src="https://images.unsplash.com/photo-1545291730-faff8ca1d4b0?w=400&h=300&fit=crop" alt="Dekorasi Pelaminan" class="w-full h-48 object-cover">
            </div>
            <div class="gallery-item rounded-xl overflow-hidden" onclick="openModal(this.querySelector('img').src)">
                <img src="https://images.unsplash.com/photo-1573495611646-18408c21ed21?w=400&h=300&fit=crop" alt="Tata Rias" class="w-full h-48 object-cover">
            </div>
            <div class="gallery-item rounded-xl overflow-hidden" onclick="openModal(this.querySelector('img').src)">
                <img src="https://images.unsplash.com/photo-1465495976277-4387d4b0e4a6?w=400&h=300&fit=crop" alt="Gamelan" class="w-full h-48 object-cover">
            </div>
            <div class="gallery-item rounded-xl overflow-hidden" onclick="openModal(this.querySelector('img').src)">
                <img src="https://images.unsplash.com/photo-1469371670807-013ccf25f16a?w=400&h=300&fit=crop" alt="Upacara Panggih" class="w-full h-48 object-cover">
            </div>
        </div>
    </div>
</section>

<!-- Vendor List -->
<section id="vendors" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Tim <span class="bg-gradient-to-r from-blue-600 to-red-600 bg-clip-text text-transparent">Vendor</span>
            </h2>
            <p class="text-lg text-gray-600">Kolaborasi dengan vendor terbaik untuk hasil sempurna</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Vendor Cards -->
            <div class="vendor-card bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-blue-700 rounded-full flex items-center justify-center">
                        <i class="fas fa-camera text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-900">Fotografi</h3>
                        <p class="text-sm text-gray-600">Moments Photography</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-4">Spesialis fotografi pernikahan tradisional dengan pengalaman 8+ tahun</p>
                <div class="flex justify-between items-center">
                    <div class="flex text-yellow-400 text-sm">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="text-xs text-gray-500">Portfolio: 150+</span>
                </div>
            </div>
            
            <div class="vendor-card bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-600 to-green-700 rounded-full flex items-center justify-center">
                        <i class="fas fa-seedling text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-900">Dekorasi</h3>
                        <p class="text-sm text-gray-600">Traditional Decor</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-4">Ahli dekorasi pernikahan adat dengan sentuhan modern yang elegan</p>
                <div class="flex justify-between items-center">
                    <div class="flex text-yellow-400 text-sm">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="text-xs text-gray-500">Projects: 200+</span>
                </div>
            </div>
            
            <div class="vendor-card bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-600 to-purple-700 rounded-full flex items-center justify-center">
                        <i class="fas fa-utensils text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-900">Catering</h3>
                        <p class="text-sm text-gray-600">Royal Catering</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-4">Menu tradisional dan modern dengan kualitas terjamin untuk 500+ tamu</p>
                <div class="flex justify-between items-center">
                    <div class="flex text-yellow-400 text-sm">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="text-xs text-gray-500">Events: 300+</span>
                </div>
            </div>
            
            <div class="vendor-card bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-red-600 to-red-700 rounded-full flex items-center justify-center">
                        <i class="fas fa-music text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-900">Gamelan</h3>
                        <p class="text-sm text-gray-600">Sekar Arum Gamelan</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-4">Grup gamelan tradisional untuk mengiringi prosesi pernikahan adat Jawa</p>
                <div class="flex justify-between items-center">
                    <div class="flex text-yellow-400 text-sm">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="text-xs text-gray-500">Experience: 15+ years</span>
                </div>
            </div>
            
            <div class="vendor-card bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-pink-600 to-pink-700 rounded-full flex items-center justify-center">
                        <i class="fas fa-spa text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-900">Make Up</h3>
                        <p class="text-sm text-gray-600">Putri Beauty</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-4">MUA spesialis tata rias pengantin adat Jawa dengan teknik terkini</p>
                <div class="flex justify-between items-center">
                    <div class="flex text-yellow-400 text-sm">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="text-xs text-gray-500">Clients: 100+</span>
                </div>
            </div>
            
            <div class="vendor-card bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-indigo-600 to-indigo-700 rounded-full flex items-center justify-center">
                        <i class="fas fa-car text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-900">Transportation</h3>
                        <p class="text-sm text-gray-600">Luxury Wedding Cars</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-4">Armada mobil pengantin mewah dan transportasi tamu undangan</p>
                <div class="flex justify-between items-center">
                    <div class="flex text-yellow-400 text-sm">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="text-xs text-gray-500">Fleet: 50+ cars</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Event Timeline -->
<section id="timeline" class="py-20 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Timeline <span class="bg-gradient-to-r from-blue-600 to-red-600 bg-clip-text text-transparent">Acara</span>
            </h2>
            <p class="text-lg text-gray-600">Rundown lengkap pernikahan adat Jawa</p>
        </div>
        
        <div class="relative">
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-bold text-gray-900">Hari 1 - Siraman & Midodareni</h3>
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">15 Oktober 2024</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-2">Siraman (09:00 - 11:00)</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Prosesi pembersihan diri</li>
                                <li>• Dipimpin keluarga senior</li>
                                <li>• Doa dan berkah</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-2">Midodareni (19:00 - 23:00)</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Malam sebelum akad</li>
                                <li>• Hiburan gamelan</li>
                                <li>• Jamuan keluarga</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-dot bg-green-600" style="box-shadow: 0 0 0 3px #16a34a;"></div>
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-bold text-gray-900">Hari 2 - Akad & Resepsi</h3>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">16 Oktober 2024</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-2">Akad Nikah (08:00 - 10:00)</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Ijab kabul</li>
                                <li>• Prosesi panggih</li>
                                <li>• Tukar cincin</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-2">Resepsi (18:00 - 22:00)</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Penyambutan tamu</li>
                                <li>• Dinner & entertainment</li>
                                <li>• Potong tumpeng</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Client Testimonial -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Testimoni <span class="bg-gradient-to-r from-blue-600 to-red-600 bg-clip-text text-transparent">Klien</span>
            </h2>
        </div>
        
        <div class="testimonial-card rounded-2xl p-8">
            <div class="flex items-start mb-6">
                <img src="https://images.unsplash.com/photo-1494790108755-2616b612b1e5?w=80&h=80&fit=crop&crop=face" alt="Client" class="w-16 h-16 rounded-full">
                <div class="ml-4">
                    <h3 class="font-semibold text-gray-900">Sari & Budi Santoso</h3>
                    <p class="text-gray-600">Pengantin</p>
                    <div class="flex text-yellow-400 mt-1">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
            
            <blockquote class="text-lg text-gray-700 italic leading-relaxed">
                "Prima Wedding benar-benar luar biasa! Mereka berhasil mewujudkan pernikahan adat Jawa impian kami. 
                Setiap detail diperhatikan dengan sempurna, dari dekorasi pelaminan yang megah hingga koordinasi 
                prosesi yang lancar. Tim vendor yang dipilih juga sangat profesional. Terima kasih telah membuat 
                hari spesial kami menjadi tak terlupakan!"
            </blockquote>
            
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <div class="text-2xl font-bold text-blue-600">5.0</div>
                        <div class="text-sm text-gray-600">Rating</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-green-600">100%</div>
                        <div class="text-sm text-gray-600">Satisfaction</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-purple-600">Perfect</div>
                        <div class="text-sm text-gray-600">Experience</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Portfolios -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Portfolio <span class="bg-gradient-to-r from-blue-600 to-red-600 bg-clip-text text-transparent">Lainnya</span>
            </h2>
            <p class="text-lg text-gray-600">Lihat karya wedding organizer lainnya</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Related Portfolio Items -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=400&h=250&fit=crop" alt="Modern Garden Wedding" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="font-bold text-lg mb-2">Modern Garden Wedding</h3>
                    <p class="text-gray-600 text-sm mb-4">Blossom Events • Bandung</p>
                    <a href="#" class="text-blue-600 font-semibold hover:text-blue-800">Lihat Detail →</a>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1606800052052-a08af7148866?w=400&h=250&fit=crop" alt="Intimate Wedding" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="font-bold text-lg mb-2">Intimate Ceremony</h3>
                    <p class="text-gray-600 text-sm mb-4">Intimate Moments • Yogyakarta</p>
                    <a href="#" class="text-blue-600 font-semibold hover:text-blue-800">Lihat Detail →</a>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=400&h=250&fit=crop" alt="Luxury Wedding" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="font-bold text-lg mb-2">Luxury Hotel Wedding</h3>
                    <p class="text-gray-600 text-sm mb-4">Luxury Events • Surabaya</p>
                    <a href="#" class="text-blue-600 font-semibold hover:text-blue-800">Lihat Detail →</a>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('portfolio') }}" class="bg-gradient-to-r from-blue-600 to-red-600 text-white px-8 py-4 rounded-full font-semibold hover:from-blue-700 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Portfolio
            </a>
        </div>
    </div>
</section>

<!-- Image Modal -->
<div id="imageModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <div class="modal-content">
        <img id="modalImage" src="" alt="Gallery Image">
        <button class="prev" onclick="changeImage(-1)">&#10094;</button>
        <button class="next" onclick="changeImage(1)">&#10095;</button>
    </div>
</div>

<!-- Floating Navigation -->
<div class="floating-nav">
    <div class="nav-item bg-blue-600 text-white shadow-lg hover:bg-blue-700" onclick="scrollToSection('gallery')" title="Gallery">
        <i class="fas fa-images"></i>
    </div>
    <div class="nav-item bg-green-600 text-white shadow-lg hover:bg-green-700" onclick="scrollToSection('vendors')" title="Vendors">
        <i class="fas fa-users"></i>
    </div>
    <div class="nav-item bg-purple-600 text-white shadow-lg hover:bg-purple-700" onclick="scrollToSection('timeline')" title="Timeline">
        <i class="fas fa-calendar"></i>
    </div>
    <div class="nav-item bg-red-600 text-white shadow-lg hover:bg-red-700" onclick="scrollToTop()" title="Back to Top">
        <i class="fas fa-arrow-up"></i>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Gallery modal functionality
    let currentImageIndex = 0;
    const galleryImages = [
        'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1606800052052-a08af7148866?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1545291730-faff8ca1d4b0?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1573495611646-18408c21ed21?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1465495976277-4387d4b0e4a6?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1469371670807-013ccf25f16a?w=800&h=600&fit=crop'
    ];

    function openModal(imageSrc) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        
        currentImageIndex = galleryImages.findIndex(img => imageSrc.includes(img.split('?')[0].split('/').pop()));
        if (currentImageIndex === -1) currentImageIndex = 0;
        
        modalImage.src = galleryImages[currentImageIndex];
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function changeImage(direction) {
        currentImageIndex += direction;
        
        if (currentImageIndex >= galleryImages.length) {
            currentImageIndex = 0;
        } else if (currentImageIndex < 0) {
            currentImageIndex = galleryImages.length - 1;
        }
        
        document.getElementById('modalImage').src = galleryImages[currentImageIndex];
    }

    // Smooth scroll functions
    function scrollToSection(sectionId) {
        const section = document.getElementById(sectionId);
        if (section) {
            section.scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('imageModal');
        if (event.target === modal) {
            closeModal();
        }
    }

    // Keyboard navigation for modal
    document.addEventListener('keydown', function(event) {
        const modal = document.getElementById('imageModal');
        if (modal.style.display === 'block') {
            if (event.key === 'Escape') {
                closeModal();
            } else if (event.key === 'ArrowLeft') {
                changeImage(-1);
            } else if (event.key === 'ArrowRight') {
                changeImage(1);
            }
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

    // Observe elements for animation
    document.addEventListener('DOMContentLoaded', function() {
        const animateElements = document.querySelectorAll('.vendor-card, .gallery-item, .timeline-item');
        
        animateElements.forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(20px)';
            element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(element);
        });
    });
</script>
@endpush
