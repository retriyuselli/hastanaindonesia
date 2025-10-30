@extends('layouts.app')

@section('title', $member->organizer_name . ' - HASTANA Indonesia')
@section('description', $member->description ?? 'Detail informasi wedding organizer ' . $member->organizer_name)

@push('styles')
<style>
    .vendor-sidebar {
        position: sticky;
        top: 100px;
    }
    
    .tab-button {
        padding: 1rem 1rem;
        border: none;
        background: transparent;
        color: #6b7280;
        font-weight: 500;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        border-right: 1px solid #e5e7eb;
        transition: all 0.3s;
    }
    
    .tab-button:last-child {
        border-right: none;
    }
    
    .tab-button:hover {
        color: #1f2937;
    }
    
    .tab-button.active {
        color: #ef4444;
        border-bottom-color: #ef4444;
    }
    
    .deal-badge {
        position: absolute;
        top: 0.5rem;
        left: 0.5rem;
        background: #ef4444;
        color: white;
        padding: 0.2rem 0.5rem;
        border-radius: 0.5rem;
        font-size: 0.625rem;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 0.2rem;
    }
    
    .price-badge {
        position: absolute;
        bottom: 0.5rem;
        left: 0.5rem;
        background: #ef4444;
        color: white;
        padding: 0.3rem 0.5rem;
        border-radius: 0.5rem;
        font-weight: bold;
        font-size: 0.625rem;
        line-height: 1;
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
    }
    
    /* Lightbox Styles */
    .lightbox {
        display: none;
        position: fixed;
        z-index: 99999;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.95);
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    
    .lightbox.active {
        display: flex !important;
    }
    
    .lightbox-content {
        max-width: 90vw;
        max-height: 90vh;
        width: auto;
        height: auto;
        object-fit: contain;
        animation: zoomIn 0.3s;
        border-radius: 8px;
    }
    
    @keyframes zoomIn {
        from {
            transform: scale(0.5);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }
    
    .lightbox-close {
        position: absolute;
        top: 20px;
        right: 40px;
        color: white;
        font-size: 50px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
        z-index: 100000;
        background: rgba(0, 0, 0, 0.5);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
    }
    
    .lightbox-close:hover {
        color: #ef4444;
        background: rgba(0, 0, 0, 0.8);
    }
    
    .lightbox-prev,
    .lightbox-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: white;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
        padding: 20px;
        transition: 0.3s;
        user-select: none;
        z-index: 100000;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .lightbox-prev {
        left: 30px;
    }
    
    .lightbox-next {
        right: 30px;
    }
    
    .lightbox-prev:hover,
    .lightbox-next:hover {
        color: #ef4444;
        background: rgba(0, 0, 0, 0.8);
    }
</style>
@endpush

@push('scripts')
<script>
// Array of images
const galleryImages = [
    'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&h=800&fit=crop',
    'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=800&h=800&fit=crop',
    'https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=800&h=800&fit=crop',
    'https://images.unsplash.com/photo-1606800052052-a08af7148866?w=800&h=800&fit=crop',
    'https://images.unsplash.com/photo-1591604466107-ec97de577aff?w=800&h=800&fit=crop',
    'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=800&h=800&fit=crop',
    'https://images.unsplash.com/photo-1522673607200-164d1b6ce486?w=800&h=800&fit=crop',
    'https://images.unsplash.com/photo-1529636798458-92182e662485?w=800&h=800&fit=crop'
];

let currentIndex = 0;

// Open lightbox
function openLightbox(index) {
    currentIndex = index;
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    
    console.log('Opening lightbox, index:', index);
    
    lightboxImg.src = galleryImages[index];
    lightbox.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    console.log('Lightbox display:', lightbox.style.display);
}

// Close lightbox
function closeLightbox() {
    const lightbox = document.getElementById('lightbox');
    lightbox.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Previous image
function prevImage() {
    currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
    document.getElementById('lightbox-img').src = galleryImages[currentIndex];
}

// Next image
function nextImage() {
    currentIndex = (currentIndex + 1) % galleryImages.length;
    document.getElementById('lightbox-img').src = galleryImages[currentIndex];
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Loaded');
    
    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            tabButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            tabContents.forEach(content => content.classList.remove('active'));
            
            const targetContent = document.getElementById(targetTab);
            if (targetContent) {
                targetContent.classList.add('active');
            }
        });
    });
    
    // Lightbox close on background click
    const lightbox = document.getElementById('lightbox');
    if (lightbox) {
        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox) {
                closeLightbox();
            }
        });
    }
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        const lightbox = document.getElementById('lightbox');
        if (lightbox.style.display === 'flex') {
            if (e.key === 'Escape') {
                closeLightbox();
            } else if (e.key === 'ArrowLeft') {
                prevImage();
            } else if (e.key === 'ArrowRight') {
                nextImage();
            }
        }
    });
});
</script>
@endpush

@section('content')

<!-- Breadcrumb -->
<div class="bg-gray-50 py-4 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center space-x-2 text-xs">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Home</a>
            <i class="fas fa-chevron-right text-gray-400" style="font-size: 0.65rem;"></i>
            <a href="{{ route('members') }}" class="text-gray-500 hover:text-gray-700">Daftar Anggota</a>
            <i class="fas fa-chevron-right text-gray-400" style="font-size: 0.65rem;"></i>
            <span class="text-gray-900">{{ $member->organizer_name }}</span>
        </div>
    </div>
</div>

<!-- Main Content -->
<section class="py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Sidebar Kiri -->
            <div class="lg:col-span-1">
                <div class="vendor-sidebar bg-white rounded-2xl shadow-lg p-6">
                    <!-- Logo -->
                    <div class="text-center mb-6">
                        <div class="relative inline-block mb-4">
                            @if($member->logo)
                                <img src="{{ Storage::url($member->logo) }}" alt="{{ $member->organizer_name }}" class="w-24 h-24 rounded-full object-cover mx-auto border-3 border-gray-200">
                            @else
                                <div class="w-24 h-24 rounded-full bg-gray-900 flex items-center justify-center text-white text-2xl font-bold mx-auto">
                                    {{ strtoupper(substr($member->organizer_name, 0, 1)) }}
                                </div>
                            @endif
                            @if($member->verification_status == 'verified')
                            <div class="absolute bottom-0 right-0 bg-white rounded-full p-1 shadow-md">
                                <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <h1 class="text-lg font-bold text-gray-900 mb-1">{{ $member->organizer_name }}</h1>
                        @if($member->brand_name)
                        <p class="text-xs text-red-500 mb-2">{{ $member->brand_name }}</p>
                        @endif
                    </div>
                    
                    <!-- Info -->
                    <div class="space-y-3 mb-6">
                        <div>
                            <p class="text-xs font-semibold text-gray-700 mb-1">
                                @if($member->specializations && is_array($member->specializations) && count($member->specializations) > 0)
                                    {{ $member->specializations[0] }}
                                @else
                                    Wedding Organizer
                                @endif
                            </p>
                            <p class="text-xs text-gray-600">
                                {{ $member->city }} <span class="text-gray-400">·</span> 
                                @if($member->region)
                                    {{ $member->region->region_name }}
                                @else
                                    {{ $member->province }}
                                @endif
                            </p>
                        </div>
                        
                        <div class="flex items-center justify-between py-3 border-t border-b border-gray-200">
                            <div class="text-center flex-1">
                                <div class="flex items-center justify-center text-yellow-400 mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($member->rating ?? 0))
                                            <i class="fas fa-star text-xs"></i>
                                        @else
                                            <i class="far fa-star text-xs"></i>
                                        @endif
                                    @endfor
                                </div>
                                <p class="text-xs text-gray-600">
                                    <span class="font-bold text-gray-900">{{ number_format($member->rating ?? 0, 1) }}/5</span> 
                                    ({{ $member->completed_events ?? 0 }} ulasan)
                                </p>
                            </div>
                        </div>
                        
                        @if($member->price_range_min && $member->price_range_max)
                        <div>
                            <p class="text-xs text-gray-600 mb-1">Kisaran Harga</p>
                            <p class="text-xs font-semibold text-gray-900">
                                Rp {{ number_format($member->price_range_min) }} - {{ number_format($member->price_range_max) }}
                            </p>
                        </div>
                        @endif
                        
                        @if($member->established_year)
                        <div>
                            <p class="text-xs text-gray-600">Aktif <span class="font-semibold text-gray-900">{{ date('Y') - $member->established_year }} tahun lalu</span></p>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Contact Buttons -->
                    <div class="space-y-3 mb-6">
                        @if($member->phone)
                        <a href="tel:{{ $member->phone }}" class="block w-full px-4 py-2.5 bg-pink-500 text-white text-sm font-semibold rounded-lg hover:bg-pink-600 transition-colors text-center">
                            <i class="fas fa-comments mr-2"></i>Chat Vendor
                        </a>
                        @endif
                        
                        @if($member->phone)
                        <button class="block w-full px-4 py-2.5 border border-gray-300 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors text-center">
                            <i class="fas fa-list mr-2"></i>Daftar Harga
                        </button>
                        @endif
                    </div>
                    
                    <!-- Additional Info -->
                    <div class="space-y-3 pt-6 border-t border-gray-200">
                        @if($member->website)
                        <div class="flex items-center text-xs">
                            <i class="fas fa-globe text-gray-400 mr-3 w-5"></i>
                            <a href="{{ $member->website }}" target="_blank" class="text-blue-600 hover:underline truncate">{{ str_replace(['http://', 'https://'], '', $member->website) }}</a>
                        </div>
                        @endif
                        
                        @if($member->email)
                        <div class="flex items-center text-xs">
                            <i class="fas fa-envelope text-gray-400 mr-3 w-5"></i>
                            <a href="mailto:{{ $member->email }}" class="text-blue-600 hover:underline truncate">{{ $member->email }}</a>
                        </div>
                        @endif
                        
                        @if($member->phone)
                        <div class="flex items-center text-xs">
                            <i class="fas fa-phone text-gray-400 mr-3 w-5"></i>
                            <span class="text-gray-700">{{ $member->phone }}</span>
                        </div>
                        @endif
                        
                        @if($member->instagram)
                        <div class="flex items-center text-xs">
                            <i class="fab fa-instagram text-gray-400 mr-3 w-5"></i>
                            <a href="https://instagram.com/{{ $member->instagram }}" target="_blank" class="text-blue-600 hover:underline">{{ $member->instagram }}</a>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Media Sosial -->
                    @if($member->instagram || $member->website)
                    <div class="pt-6 border-t border-gray-200 mt-6">
                        <p class="text-xs font-semibold mb-3 text-gray-700">Media Sosial</p>
                        <div class="flex space-x-3">
                            @if($member->instagram)
                            <a href="https://instagram.com/{{ $member->instagram }}" target="_blank" class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center hover:bg-pink-100 transition-colors">
                                <i class="fab fa-instagram text-gray-700 text-sm"></i>
                            </a>
                            @endif
                            @if($member->website)
                            <a href="{{ $member->website }}" target="_blank" class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center hover:bg-blue-100 transition-colors">
                                <i class="fas fa-globe text-gray-700 text-sm"></i>
                            </a>
                            @endif
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $member->phone ?? '') }}" target="_blank" class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center hover:bg-green-100 transition-colors">
                                <i class="fab fa-whatsapp text-gray-700 text-sm"></i>
                            </a>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Kontak Lain -->
                    <div class="pt-6 border-t border-gray-200 mt-6">
                        <button class="text-xs text-pink-500 hover:text-pink-600 font-semibold flex items-center">
                            <i class="fas fa-flag mr-2"></i>Laporkan Vendor Ini
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="lg:col-span-3">
                <!-- Tabs -->
                <div class="bg-white rounded-t-2xl shadow-lg">
                    <div class="border-b border-gray-200 flex justify-center overflow-x-auto">
                        <button class="tab-button active text-xs flex-1 max-w-[180px]" data-tab="tab-store">Store (1)</button>
                        <button class="tab-button text-xs flex-1 max-w-[180px]" data-tab="tab-album">Album (0)</button>
                        <button class="tab-button text-xs flex-1 max-w-[180px]" data-tab="tab-ulasan">Ulasan ({{ $member->completed_events ?? 0 }})</button>
                        <button class="tab-button text-xs flex-1 max-w-[180px]" data-tab="tab-harga">Harga</button>
                        <button class="tab-button text-xs flex-1 max-w-[180px]" data-tab="tab-info">Info</button>
                        <button class="tab-button text-xs flex-1 max-w-[180px]" data-tab="tab-tentang">Tentang Kami</button>
                        {{-- <button class="tab-button text-xs flex-1 max-w-[180px]" data-tab="tab-featured">Featured</button> --}}
                    </div>
                </div>
                
                <!-- Tab Content -->
                <div class="bg-white rounded-b-2xl shadow-lg p-8">
                    
                    <!-- Tab Store -->
                    <div id="tab-store" class="tab-content active">
                        <h2 class="text-xl font-bold mb-6 text-gray-900">Products</h2>
                        
                        @if($member->activeProducts && $member->activeProducts->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @foreach($member->activeProducts as $product)
                                <a href="{{ route('members.product', ['id' => $member->id, 'productId' => $product->id]) }}" class="border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow block">
                                    <div class="relative aspect-square">
                                        <img src="{{ $product->main_image ?? 'https://images.unsplash.com/photo-1519741497674-611481863552?w=500&h=500&fit=crop' }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        @if($product->limited_offer)
                                        <span class="deal-badge">
                                            <i class="fas fa-clock"></i>
                                            Harga Terbatas
                                        </span>
                                        @endif
                                        <span class="price-badge">Diskon {{ rtrim(rtrim(number_format($product->discount / 1000000, 1), '0'), '.') }}jt</span>
                                    </div>
                                    <div class="p-4">
                                        <h3 class="font-bold text-sm text-gray-900 mb-2">{{ $product->name }}</h3>
                                        <p class="text-xs text-gray-600 mb-3">by {{ $member->organizer_name }}</p>
                                        
                                        <div class="mb-3">
                                            <p class="text-xs text-gray-500 line-through">IDR {{ number_format($product->original_price) }}</p>
                                            <p class="text-base font-bold text-gray-900">IDR {{ number_format($product->price) }}</p>
                                        </div>
                                        
                                        @if($product->badges && count($product->badges) > 0)
                                        <div class="flex flex-wrap gap-1.5">
                                            @foreach($product->badges as $badge)
                                            <span class="px-1.5 py-0.5 bg-gray-100 text-gray-700 text-[10px] rounded-full">{{ $badge }}</span>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <i class="fas fa-box-open text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500">Belum ada produk tersedia</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Tab Album -->
                    <div id="tab-album" class="tab-content">
                        <h2 class="text-xl font-bold mb-6 text-gray-900">Album Foto</h2>
                        
                        @if($member->portfolios && $member->portfolios->count() > 0)
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($member->portfolios as $portfolio)
                                    <div class="relative group cursor-pointer overflow-hidden rounded-lg">
                                        <img src="{{ Storage::url($portfolio->image) }}" alt="{{ $portfolio->title }}" class="album-image w-full h-48 object-cover transition-transform group-hover:scale-110">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all flex items-center justify-center">
                                            <i class="fas fa-search-plus text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- Sample Album Photos -->
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="relative group cursor-pointer overflow-hidden rounded-lg" onclick="openLightbox(0)">
                                    <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=800&h=800&fit=crop" alt="Wedding Photo 1" class="w-full h-48 object-cover transition-transform group-hover:scale-110" data-index="0">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all flex items-center justify-center">
                                        <i class="fas fa-search-plus text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                    </div>
                                </div>
                                
                                <div class="relative group cursor-pointer overflow-hidden rounded-lg" onclick="openLightbox(1)">
                                    <img src="https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=800&h=800&fit=crop" alt="Wedding Photo 2" class="w-full h-48 object-cover transition-transform group-hover:scale-110" data-index="1">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all flex items-center justify-center">
                                        <i class="fas fa-search-plus text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                    </div>
                                </div>
                                
                                <div class="relative group cursor-pointer overflow-hidden rounded-lg" onclick="openLightbox(2)">
                                    <img src="https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=800&h=800&fit=crop" alt="Wedding Photo 3" class="w-full h-48 object-cover transition-transform group-hover:scale-110" data-index="2">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all flex items-center justify-center">
                                        <i class="fas fa-search-plus text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                    </div>
                                </div>
                                
                                <div class="relative group cursor-pointer overflow-hidden rounded-lg" onclick="openLightbox(3)">
                                    <img src="https://images.unsplash.com/photo-1606800052052-a08af7148866?w=800&h=800&fit=crop" alt="Wedding Photo 4" class="w-full h-48 object-cover transition-transform group-hover:scale-110" data-index="3">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all flex items-center justify-center">
                                        <i class="fas fa-search-plus text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                    </div>
                                </div>
                                
                                <div class="relative group cursor-pointer overflow-hidden rounded-lg" onclick="openLightbox(4)">
                                    <img src="https://images.unsplash.com/photo-1591604466107-ec97de577aff?w=800&h=800&fit=crop" alt="Wedding Photo 5" class="w-full h-48 object-cover transition-transform group-hover:scale-110" data-index="4">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all flex items-center justify-center">
                                        <i class="fas fa-search-plus text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                    </div>
                                </div>
                                
                                <div class="relative group cursor-pointer overflow-hidden rounded-lg" onclick="openLightbox(5)">
                                    <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=800&h=800&fit=crop" alt="Wedding Photo 6" class="w-full h-48 object-cover transition-transform group-hover:scale-110" data-index="5">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all flex items-center justify-center">
                                        <i class="fas fa-search-plus text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                    </div>
                                </div>
                                
                                <div class="relative group cursor-pointer overflow-hidden rounded-lg" onclick="openLightbox(6)">
                                    <img src="https://images.unsplash.com/photo-1522673607200-164d1b6ce486?w=800&h=800&fit=crop" alt="Wedding Photo 7" class="w-full h-48 object-cover transition-transform group-hover:scale-110" data-index="6">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all flex items-center justify-center">
                                        <i class="fas fa-search-plus text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                    </div>
                                </div>
                                
                                <div class="relative group cursor-pointer overflow-hidden rounded-lg" onclick="openLightbox(7)">
                                    <img src="https://images.unsplash.com/photo-1529636798458-92182e662485?w=800&h=800&fit=crop" alt="Wedding Photo 8" class="w-full h-48 object-cover transition-transform group-hover:scale-110" data-index="7">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all flex items-center justify-center">
                                        <i class="fas fa-search-plus text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Tab Ulasan -->
                    <div id="tab-ulasan" class="tab-content">
                        <h2 class="text-xl font-bold mb-6 text-gray-900">Ulasan Pelanggan</h2>
                        
                        <!-- Rating Summary -->
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <div class="flex items-center gap-8">
                                <div class="text-center">
                                    <div class="text-4xl font-bold text-gray-900 mb-2">{{ number_format($member->rating ?? 0, 1) }}</div>
                                    <div class="flex items-center justify-center text-yellow-400 mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($member->rating ?? 0))
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $member->completed_events ?? 0 }} ulasan</p>
                                </div>
                                
                                <div class="flex-1">
                                    @for($i = 5; $i >= 1; $i--)
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="text-xs text-gray-600 w-12">{{ $i }} star</span>
                                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                                <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $i == 5 ? '80' : ($i == 4 ? '15' : '5') }}%"></div>
                                            </div>
                                            <span class="text-xs text-gray-600 w-12">{{ $i == 5 ? '80' : ($i == 4 ? '15' : '5') }}%</span>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        
                        <!-- Reviews List -->
                        <div class="space-y-6">
                            <!-- Sample Review -->
                            <div class="border-b border-gray-200 pb-6">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center text-white font-bold">
                                        A
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="text-sm font-semibold text-gray-900">Andi & Siti</h4>
                                            <span class="text-xs text-gray-500">2 minggu lalu</span>
                                        </div>
                                        <div class="flex items-center text-yellow-400 mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-xs"></i>
                                            @endfor
                                        </div>
                                        <p class="text-xs text-gray-700 mb-2">Pelayanan sangat memuaskan! Tim {{ $member->organizer_name }} sangat profesional dan membantu kami merencanakan pernikahan impian. Hasilnya melebihi ekspektasi!</p>
                                        <div class="flex gap-2">
                                            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=100&h=100&fit=crop" alt="Review" class="w-20 h-20 object-cover rounded">
                                            <img src="https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=100&h=100&fit=crop" alt="Review" class="w-20 h-20 object-cover rounded">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Empty State -->
                            @if(($member->completed_events ?? 0) == 0)
                            <div class="text-center py-12">
                                <i class="fas fa-star text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500">Belum ada ulasan</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Tab Harga -->
                    {{-- <div id="tab-harga" class="tab-content">
                        <h2 class="text-xl font-bold mb-6 text-gray-900">Daftar Harga</h2>
                        
                        <div class="space-y-6">
                            <!-- Price Package 1 -->
                            <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 mb-2">Paket Bronze</h3>
                                        <p class="text-sm text-gray-600">Paket hemat untuk acara intimate</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500 mb-1">Mulai dari</p>
                                        <p class="text-2xl font-bold text-pink-600">Rp {{ number_format($member->price_range_min ?? 5000000) }}</p>
                                    </div>
                                </div>
                                <ul class="space-y-2">
                                    <li class="flex items-start text-sm text-gray-700">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        Wedding Organizer & Coordinator
                                    </li>
                                    <li class="flex items-start text-sm text-gray-700">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        Dekorasi Pelaminan Sederhana
                                    </li>
                                    <li class="flex items-start text-sm text-gray-700">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        Dokumentasi Foto (300 foto)
                                    </li>
                                    <li class="flex items-start text-sm text-gray-700">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        Make Up Pengantin
                                    </li>
                                </ul>
                                <button class="mt-4 w-full py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-colors text-sm font-semibold">
                                    Hubungi Kami
                                </button>
                            </div>
                            
                            <!-- Price Package 2 -->
                            <div class="border-2 border-pink-500 rounded-xl p-6 hover:shadow-lg transition-shadow relative">
                                <span class="absolute -top-3 left-6 bg-pink-500 text-white px-3 py-1 rounded-full text-xs font-bold">TERPOPULER</span>
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 mb-2">Paket Silver</h3>
                                        <p class="text-sm text-gray-600">Paket lengkap untuk pernikahan sempurna</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500 mb-1">Mulai dari</p>
                                        <p class="text-2xl font-bold text-pink-600">Rp {{ number_format(($member->price_range_min ?? 5000000) + 10000000) }}</p>
                                    </div>
                                </div>
                                <ul class="space-y-2">
                                    <li class="flex items-start text-sm text-gray-700">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        Semua benefit Paket Bronze
                                    </li>
                                    <li class="flex items-start text-sm text-gray-700">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        Dekorasi Premium
                                    </li>
                                    <li class="flex items-start text-sm text-gray-700">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        Video Cinematic
                                    </li>
                                    <li class="flex items-start text-sm text-gray-700">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        Prewedding Indoor/Outdoor
                                    </li>
                                    <li class="flex items-start text-sm text-gray-700">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        Live Music
                                    </li>
                                </ul>
                                <button class="mt-4 w-full py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-colors text-sm font-semibold">
                                    Hubungi Kami
                                </button>
                            </div>
                            
                            <!-- Price Package 3 -->
                            <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 mb-2">Paket Gold</h3>
                                        <p class="text-sm text-gray-600">Paket premium all-in untuk pernikahan mewah</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500 mb-1">Mulai dari</p>
                                        <p class="text-2xl font-bold text-pink-600">Rp {{ number_format($member->price_range_max ?? 50000000) }}</p>
                                    </div>
                                </div>
                                <ul class="space-y-2">
                                    <li class="flex items-start text-sm text-gray-700">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        Semua benefit Paket Silver
                                    </li>
                                    <li class="flex items-start text-sm text-gray-700">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        Dekorasi Mewah Custom Design
                                    </li>
                                    <li class="flex items-start text-sm text-gray-700">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        Full Team Photography & Videography
                                    </li>
                                    <li class="flex items-start text-sm text-gray-700">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        Wedding Cake 5 Tier
                                    </li>
                                    <li class="flex items-start text-sm text-gray-700">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        Souvenir & Hampers Premium
                                    </li>
                                </ul>
                                <button class="mt-4 w-full py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-colors text-sm font-semibold">
                                    Hubungi Kami
                                </button>
                            </div>
                        </div>
                        
                        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <p class="text-sm text-blue-800">
                                <i class="fas fa-info-circle mr-2"></i>
                                <strong>Catatan:</strong> Harga dapat disesuaikan dengan kebutuhan dan budget Anda. Hubungi kami untuk konsultasi gratis dan penawaran khusus.
                            </p>
                        </div>
                    </div> --}}
                    
                    <!-- Tab Info -->
                    <div id="tab-info" class="tab-content">
                        <h2 class="text-xl font-bold mb-6 text-gray-900">Informasi Vendor</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Info -->
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 mb-1">Nama Vendor</p>
                                    <p class="text-sm text-gray-900">{{ $member->organizer_name }}</p>
                                </div>
                                
                                @if($member->brand_name)
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 mb-1">Nama Brand</p>
                                    <p class="text-sm text-gray-900">{{ $member->brand_name }}</p>
                                </div>
                                @endif
                                
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 mb-1">Lokasi</p>
                                    <p class="text-sm text-gray-900">{{ $member->city }}, {{ $member->province }}</p>
                                </div>
                                
                                @if($member->established_year)
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 mb-1">Tahun Berdiri</p>
                                    <p class="text-sm text-gray-900">{{ $member->established_year }}</p>
                                </div>
                                @endif
                                
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 mb-1">Status Verifikasi</p>
                                    <p class="text-sm">
                                        @if($member->verification_status == 'verified')
                                            <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Terverifikasi
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">
                                                Belum Terverifikasi
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Additional Info -->
                            <div class="space-y-4">
                                @if($member->price_range_min && $member->price_range_max)
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 mb-1">Kisaran Harga</p>
                                    <p class="text-sm text-gray-900">Rp {{ number_format($member->price_range_min) }} - Rp {{ number_format($member->price_range_max) }}</p>
                                </div>
                                @endif
                                
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 mb-1">Rating</p>
                                    <div class="flex items-center">
                                        <div class="flex text-yellow-400 mr-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($member->rating ?? 0))
                                                    <i class="fas fa-star text-sm"></i>
                                                @else
                                                    <i class="far fa-star text-sm"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="text-sm text-gray-900">{{ number_format($member->rating ?? 0, 1) }}/5 ({{ $member->completed_events ?? 0 }} ulasan)</span>
                                    </div>
                                </div>
                                
                                @if($member->website)
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 mb-1">Website</p>
                                    <a href="{{ $member->website }}" target="_blank" class="text-sm text-blue-600 hover:underline">{{ $member->website }}</a>
                                </div>
                                @endif
                                
                                @if($member->email)
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 mb-1">Email</p>
                                    <a href="mailto:{{ $member->email }}" class="text-sm text-blue-600 hover:underline">{{ $member->email }}</a>
                                </div>
                                @endif
                                
                                @if($member->phone)
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 mb-1">Telepon</p>
                                    <a href="tel:{{ $member->phone }}" class="text-sm text-blue-600 hover:underline">{{ $member->phone }}</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Specializations -->
                        @if($member->specializations && is_array($member->specializations))
                        <div class="mt-8">
                            <h3 class="text-lg font-bold mb-4 text-gray-900">Spesialisasi</h3>
                            <div class="flex flex-wrap gap-3">
                                @foreach($member->specializations as $specialization)
                                    <span class="bg-blue-100 text-blue-800 px-3 py-2 rounded-full text-xs font-semibold">{{ $specialization }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        <!-- Services -->
                        @if($member->services && is_array($member->services))
                        <div class="mt-8">
                            <h3 class="text-lg font-bold mb-4 text-gray-900">Layanan yang Ditawarkan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($member->services as $service)
                                    <div class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span class="text-sm text-gray-700">{{ $service }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Tab Tentang Kami -->
                    <div id="tab-tentang" class="tab-content">
                        <h2 class="text-xl font-bold mb-6 text-gray-900">Tentang {{ $member->organizer_name }}</h2>
                        
                        @if($member->description)
                        <div class="mb-8">
                            <p class="text-sm text-gray-700 leading-relaxed mb-4">{{ $member->description }}</p>
                        </div>
                        @endif
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="text-center p-6 bg-gray-50 rounded-lg">
                                <div class="text-3xl font-bold text-pink-600 mb-2">{{ $member->completed_events ?? 0 }}+</div>
                                <p class="text-sm text-gray-600">Event Sukses</p>
                            </div>
                            <div class="text-center p-6 bg-gray-50 rounded-lg">
                                <div class="text-3xl font-bold text-pink-600 mb-2">{{ date('Y') - ($member->established_year ?? date('Y')) }}+</div>
                                <p class="text-sm text-gray-600">Tahun Pengalaman</p>
                            </div>
                            <div class="text-center p-6 bg-gray-50 rounded-lg">
                                <div class="text-3xl font-bold text-pink-600 mb-2">{{ number_format($member->rating ?? 0, 1) }}</div>
                                <p class="text-sm text-gray-600">Rating Pelanggan</p>
                            </div>
                        </div>
                        
                        <div class="mb-8">
                            <h3 class="text-lg font-bold mb-4 text-gray-900">Mengapa Memilih Kami?</h3>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                        <i class="fas fa-award text-pink-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900 mb-1">Profesional & Berpengalaman</h4>
                                        <p class="text-xs text-gray-600">Tim kami memiliki pengalaman bertahun-tahun dalam menangani berbagai jenis acara pernikahan.</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                        <i class="fas fa-heart text-pink-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900 mb-1">Pelayanan Terbaik</h4>
                                        <p class="text-xs text-gray-600">Kami selalu mengutamakan kepuasan klien dengan memberikan pelayanan terbaik di setiap detail acara.</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                        <i class="fas fa-gem text-pink-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900 mb-1">Kualitas Premium</h4>
                                        <p class="text-xs text-gray-600">Menggunakan vendor-vendor pilihan dengan kualitas terbaik untuk memastikan acara Anda sempurna.</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                        <i class="fas fa-handshake text-pink-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900 mb-1">Harga Kompetitif</h4>
                                        <p class="text-xs text-gray-600">Kami menawarkan harga yang kompetitif dengan paket-paket yang bisa disesuaikan dengan budget Anda.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if($member->instagram || $member->website)
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-bold mb-4 text-gray-900">Hubungi Kami</h3>
                            <p class="text-sm text-gray-600 mb-4">Tertarik dengan layanan kami? Hubungi kami sekarang untuk konsultasi gratis!</p>
                            <div class="flex gap-3">
                                @if($member->phone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $member->phone) }}" target="_blank" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors text-sm font-semibold flex items-center">
                                    <i class="fab fa-whatsapp mr-2"></i>WhatsApp
                                </a>
                                @endif
                                @if($member->instagram)
                                <a href="https://instagram.com/{{ $member->instagram }}" target="_blank" class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-colors text-sm font-semibold flex items-center">
                                    <i class="fab fa-instagram mr-2"></i>Instagram
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Tab Featured -->
                    {{-- <div id="tab-featured" class="tab-content">
                        <h2 class="text-xl font-bold mb-6 text-gray-900">Featured</h2>
                        
                        <div class="text-center py-12">
                            <i class="fas fa-star text-gray-300 text-5xl mb-4"></i>
                            <p class="text-gray-500">Konten featured akan segera hadir</p>
                        </div>
                    </div> --}}
                    
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- Lightbox Modal -->
<div id="lightbox" class="lightbox" style="display: none;">
    <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
    <span class="lightbox-prev" onclick="prevImage()">&#10094;</span>
    <span class="lightbox-next" onclick="nextImage()">&#10095;</span>
    <img id="lightbox-img" class="lightbox-content" alt="Lightbox Image">
</div>

<!-- Related Members -->
@if($relatedMembers && $relatedMembers->count() > 0)
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold mb-8 text-gray-900">Vendor Lainnya</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedMembers as $related)
            <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-all">
                <div class="text-center">
                    <div class="relative inline-block mb-3">
                        @if($related->logo)
                            <img src="{{ Storage::url($related->logo) }}" alt="{{ $related->organizer_name }}" class="w-24 h-24 rounded-full object-cover mx-auto border-2 border-gray-200">
                        @else
                            <div class="w-24 h-24 rounded-full bg-gray-900 flex items-center justify-center text-white text-xl font-bold mx-auto">
                                {{ strtoupper(substr($related->organizer_name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    
                    <h3 class="font-bold text-base mb-1">{{ $related->organizer_name }}</h3>
                    <p class="text-xs text-gray-600 mb-2">{{ $related->city }}</p>
                    
                    <div class="text-xs text-gray-700 mb-3">
                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                        {{ number_format($related->rating ?? 0, 1) }}/5
                    </div>
                    
                    <a href="{{ route('members.show', $related->id) }}" class="block w-full px-4 py-2 border border-gray-300 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors text-center">
                        <i class="fas fa-eye mr-2"></i>Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
