@extends('layouts.app')

@section('title', 'Gallery - HASTANA Indonesia')
@section('description', 'Galeri foto dan video karya terbaik dari anggota HASTANA Indonesia - Wedding Organizer Profesional')

@push('styles')
<style>
    /* Gallery Styles */
    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
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
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 1.5rem;
    }
    
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }

    .filter-btn {
        transition: all 0.3s ease;
    }

    .filter-btn.active {
        background: linear-gradient(135deg, #1e40af, #dc2626);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
    }

    .gradient-text {
        background: linear-gradient(135deg, #1e40af, #dc2626);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Lightbox Modal */
    .lightbox-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.95);
        z-index: 9999;
        overflow: auto;
    }

    .lightbox-modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lightbox-content {
        max-width: 90%;
        max-height: 90vh;
        animation: zoomIn 0.3s ease;
    }

    @keyframes zoomIn {
        from {
            transform: scale(0.8);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .lightbox-close {
        position: absolute;
        top: 2rem;
        right: 2rem;
        width: 48px;
        height: 48px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .lightbox-close:hover {
        transform: rotate(90deg);
        background: #dc2626;
        color: white;
    }

    .lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 48px;
        height: 48px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .lightbox-nav:hover {
        background: #1e40af;
        color: white;
        transform: translateY(-50%) scale(1.1);
    }

    .lightbox-prev {
        left: 2rem;
    }

    .lightbox-next {
        right: 2rem;
    }

    .gallery-info {
        position: absolute;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(255, 255, 255, 0.95);
        padding: 1.5rem 2rem;
        border-radius: 1rem;
        max-width: 600px;
        width: 90%;
        backdrop-filter: blur(10px);
    }

    /* Dropdown Filter Styles */
    .filter-dropdown {
        position: relative;
        display: inline-block;
    }

    .filter-dropdown-button {
        background: linear-gradient(135deg, #1e40af, #dc2626);
        color: white;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
        min-width: 280px;
        justify-content: space-between;
    }

    .filter-dropdown-button:hover {
        box-shadow: 0 6px 20px rgba(30, 64, 175, 0.4);
        transform: translateY(-2px);
    }

    .filter-dropdown-content {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        margin-top: 8px;
        max-height: 400px;
        overflow-y: auto;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        z-index: 50;
    }

    .filter-dropdown.active .filter-dropdown-content {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .filter-dropdown-item {
        padding: 12px 20px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #f3f4f6;
    }

    .filter-dropdown-item:last-child {
        border-bottom: none;
    }

    .filter-dropdown-item:hover {
        background: linear-gradient(135deg, rgba(30, 64, 175, 0.1), rgba(220, 38, 38, 0.05));
        padding-left: 24px;
    }

    .filter-dropdown-item.active {
        background: linear-gradient(135deg, rgba(30, 64, 175, 0.15), rgba(220, 38, 38, 0.1));
        color: #1e40af;
        font-weight: 600;
    }

    .filter-dropdown-item .count {
        background: #e5e7eb;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .filter-dropdown-item.active .count {
        background: linear-gradient(135deg, #1e40af, #dc2626);
        color: white;
    }

    .dropdown-arrow {
        transition: transform 0.3s ease;
    }

    .filter-dropdown.active .dropdown-arrow {
        transform: rotate(180deg);
    }

    @media (max-width: 768px) {
        .lightbox-close {
            top: 1rem;
            right: 1rem;
            width: 40px;
            height: 40px;
        }

        .lightbox-nav {
            width: 40px;
            height: 40px;
        }

        .lightbox-prev {
            left: 1rem;
        }

        .lightbox-next {
            right: 1rem;
        }

        .gallery-info {
            bottom: 1rem;
            padding: 1rem;
        }

        .filter-dropdown-button {
            min-width: 100%;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-gray-900 via-blue-900 to-red-900 text-white py-20 overflow-hidden mt-20">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 1200 600%22><defs><pattern id=%22wedding-pattern%22 x=%220%22 y=%220%22 width=%22100%22 height=%22100%22 patternUnits=%22userSpaceOnUse%22><circle cx=%2250%22 cy=%2250%22 r=%2220%22 fill=%22none%22 stroke=%22rgba(255,255,255,0.1)%22 stroke-width=%221%22/><circle cx=%2250%22 cy=%2250%22 r=%2210%22 fill=%22none%22 stroke=%22rgba(255,255,255,0.05)%22 stroke-width=%221%22/></pattern></defs><rect width=%22100%25%22 height=%22100%25%22 fill=%22url(%23wedding-pattern)%22/></svg>'); background-size: 100px 100px;"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-block mb-6">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-red-500 rounded-full flex items-center justify-center shadow-2xl">
                <i class="fas fa-images text-3xl"></i>
            </div>
        </div>
        
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
            Gallery <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-red-400">HASTANA INDONESIA</span>
        </h1>
        
        <p class="text-xl md:text-2xl text-gray-200 max-w-3xl mx-auto leading-relaxed">
            Momen-momen terbaik dan karya menawan dari anggota wedding organizer HASTANA Indonesia
        </p>
    </div>
</section>

<!-- Filter Section -->
<section class="py-8 bg-white border-b border-gray-200 sticky top-0 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-center items-center">
            <div class="filter-dropdown" id="filterDropdown">
                <button class="filter-dropdown-button" onclick="toggleFilterDropdown()">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-filter"></i>
                        <span id="selected-category">Semua Kategori</span>
                    </span>
                    <span class="flex items-center gap-2">
                        <span id="selected-count" class="text-sm opacity-90">({{ count($galleries) }})</span>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </span>
                </button>
                <div class="filter-dropdown-content">
                    <div class="filter-dropdown-item active" data-category="all" onclick="selectCategory('all', 'Semua Kategori', {{ count($galleries) }})">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-th text-sm"></i>
                            <span>Semua Kategori</span>
                        </span>
                        <span class="count">{{ count($galleries) }}</span>
                    </div>
                    @foreach($categories as $category => $count)
                        @if($category !== 'Semua')
                        <div class="filter-dropdown-item" data-category="{{ strtolower(str_replace(' ', '-', $category)) }}" onclick="selectCategory('{{ strtolower(str_replace(' ', '-', $category)) }}', '{{ $category }}', {{ $count }})">
                            <span class="flex items-center gap-2">
                                <i class="fas fa-tag text-sm"></i>
                                <span>{{ $category }}</span>
                            </span>
                            <span class="count">{{ $count }}</span>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Grid -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div id="gallery-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($galleries as $gallery)
            <div class="gallery-item bg-white shadow-lg" data-category="{{ strtolower(str_replace(' ', '-', $gallery['category'])) }}" data-id="{{ $gallery['id'] }}">
                <div class="aspect-square overflow-hidden bg-gray-200">
                    <img src="{{ $gallery['image'] }}" 
                         alt="{{ $gallery['title'] }}" 
                         class="w-full h-full object-cover"
                         loading="lazy"
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/800x800/e5e7eb/6b7280?text=No+Image';">
                </div>
                <div class="gallery-overlay">
                    <div class="text-white">
                        <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-semibold mb-3">
                            {{ $gallery['category'] }}
                        </span>
                        <h3 class="text-lg font-bold mb-2">{{ $gallery['title'] }}</h3>
                        <p class="text-sm text-gray-200 mb-3">{{ Str::limit($gallery['description'], 60) }}</p>
                        <div class="flex items-center text-xs text-gray-300 space-x-4">
                            <span><i class="fas fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($gallery['date'])->format('d M Y') }}</span>
                            <span><i class="fas fa-map-marker-alt mr-1"></i> {{ $gallery['location'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- No Results Message -->
        <div id="no-results" class="hidden text-center py-20">
            <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-search text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Tidak Ada Hasil</h3>
            <p class="text-gray-600">Tidak ada galeri yang cocok dengan kategori yang dipilih.</p>
        </div>
    </div>
</section>

<!-- Lightbox Modal -->
<div id="lightbox-modal" class="lightbox-modal">
    <button class="lightbox-close" onclick="closeLightbox()">
        <i class="fas fa-times text-xl"></i>
    </button>
    
    <button class="lightbox-nav lightbox-prev" onclick="navigateLightbox(-1)">
        <i class="fas fa-chevron-left text-xl"></i>
    </button>
    
    <div class="lightbox-content">
        <img id="lightbox-image" src="" alt="" class="rounded-2xl shadow-2xl">
    </div>
    
    <button class="lightbox-nav lightbox-next" onclick="navigateLightbox(1)">
        <i class="fas fa-chevron-right text-xl"></i>
    </button>
    
    <div class="gallery-info">
        <span id="lightbox-category" class="inline-block px-3 py-1 bg-gradient-to-r from-blue-600 to-red-600 text-white rounded-full text-xs font-semibold mb-2"></span>
        <h3 id="lightbox-title" class="text-xl font-bold text-gray-900 mb-2"></h3>
        <p id="lightbox-description" class="text-sm text-gray-600 mb-3"></p>
        <div class="flex items-center justify-between text-xs text-gray-500">
            <span id="lightbox-date"><i class="fas fa-calendar mr-2"></i></span>
            <span id="lightbox-location"><i class="fas fa-map-marker-alt mr-2"></i></span>
            <span id="lightbox-photographer"><i class="fas fa-camera mr-2"></i></span>
        </div>
    </div>
</div>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-gray-900 via-blue-900 to-red-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
            Ingin Karya Anda Ditampilkan di Gallery?
        </h2>
        <p class="text-lg text-gray-200 mb-10">
            Bergabunglah dengan HASTANA Indonesia dan tampilkan karya terbaik Anda
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('join') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-full hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-xl hover:shadow-2xl">
                <i class="fas fa-user-plus mr-3"></i>
                Daftar Sekarang
            </a>
            <a href="{{ route('contact') }}" class="inline-flex items-center px-8 py-4 border-2 border-white text-white font-bold rounded-full hover:bg-white hover:text-gray-900 transition-all duration-300">
                <i class="fas fa-phone mr-3"></i>
                Hubungi Kami
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Gallery data from Laravel
    const galleries = @json($galleries);
    let currentGalleryIndex = 0;
    let filteredGalleries = [...galleries];

    // Toggle Filter Dropdown
    function toggleFilterDropdown() {
        const dropdown = document.getElementById('filterDropdown');
        dropdown.classList.toggle('active');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('filterDropdown');
        if (dropdown && !dropdown.contains(e.target)) {
            dropdown.classList.remove('active');
        }
    });

    // Select Category from Dropdown
    function selectCategory(category, categoryName, count) {
        // Update button text
        document.getElementById('selected-category').textContent = categoryName;
        document.getElementById('selected-count').textContent = `(${count})`;
        
        // Update active state in dropdown items
        document.querySelectorAll('.filter-dropdown-item').forEach(item => {
            item.classList.remove('active');
        });
        event.target.closest('.filter-dropdown-item').classList.add('active');
        
        // Close dropdown
        document.getElementById('filterDropdown').classList.remove('active');
        
        // Filter gallery
        filterGallery(category);
    }

    // Filter Gallery
    function filterGallery(category) {
        // Filter items
        const items = document.querySelectorAll('.gallery-item');
        let visibleCount = 0;

        items.forEach(item => {
            if (category === 'all' || item.dataset.category === category) {
                item.style.display = 'block';
                visibleCount++;
                // Animate in
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'scale(1)';
                }, 50);
            } else {
                item.style.opacity = '0';
                item.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    item.style.display = 'none';
                }, 300);
            }
        });

        // Show/hide no results message
        const noResults = document.getElementById('no-results');
        if (visibleCount === 0) {
            noResults.classList.remove('hidden');
        } else {
            noResults.classList.add('hidden');
        }

        // Update filtered galleries for lightbox
        if (category === 'all') {
            filteredGalleries = [...galleries];
        } else {
            filteredGalleries = galleries.filter(g => 
                g.category.toLowerCase().replace(' ', '-') === category
            );
        }
    }

    // Open Lightbox
    function openLightbox(galleryId) {
        const gallery = galleries.find(g => g.id == galleryId);
        if (!gallery) return;

        currentGalleryIndex = filteredGalleries.findIndex(g => g.id == galleryId);
        
        displayLightboxImage(gallery);
        
        const modal = document.getElementById('lightbox-modal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    // Display Lightbox Image
    function displayLightboxImage(gallery) {
        document.getElementById('lightbox-image').src = gallery.image;
        document.getElementById('lightbox-category').textContent = gallery.category;
        document.getElementById('lightbox-title').textContent = gallery.title;
        document.getElementById('lightbox-description').textContent = gallery.description;
        document.getElementById('lightbox-date').innerHTML = `<i class="fas fa-calendar mr-2"></i>${new Date(gallery.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}`;
        document.getElementById('lightbox-location').innerHTML = `<i class="fas fa-map-marker-alt mr-2"></i>${gallery.location}`;
        document.getElementById('lightbox-photographer').innerHTML = `<i class="fas fa-camera mr-2"></i>${gallery.photographer}`;
    }

    // Close Lightbox
    function closeLightbox() {
        const modal = document.getElementById('lightbox-modal');
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Navigate Lightbox
    function navigateLightbox(direction) {
        currentGalleryIndex += direction;
        
        if (currentGalleryIndex < 0) {
            currentGalleryIndex = filteredGalleries.length - 1;
        } else if (currentGalleryIndex >= filteredGalleries.length) {
            currentGalleryIndex = 0;
        }
        
        displayLightboxImage(filteredGalleries[currentGalleryIndex]);
    }

    // Event Listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Add click event to gallery items
        document.querySelectorAll('.gallery-item').forEach(item => {
            item.addEventListener('click', function() {
                openLightbox(this.dataset.id);
            });
        });

        // Close lightbox on background click
        document.getElementById('lightbox-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('lightbox-modal');
            if (modal.classList.contains('active')) {
                if (e.key === 'Escape') {
                    closeLightbox();
                } else if (e.key === 'ArrowLeft') {
                    navigateLightbox(-1);
                } else if (e.key === 'ArrowRight') {
                    navigateLightbox(1);
                }
            }
        });

        // Animate gallery items on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 50);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.gallery-item').forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(item);
        });
    });
</script>
@endpush
