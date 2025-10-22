@props([
    'items' => [],
    'columns' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4',
    'gap' => 'gap-6',
    'showModal' => true,
    'showOverlay' => true
])

<div class="gallery-grid {{ $columns }} {{ $gap }} grid">
    @foreach($items as $index => $item)
        <div class="gallery-item group cursor-pointer" 
             @if($showModal) onclick="openGalleryModal({{ $index }})" @endif>
            <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200">
                
                <!-- Image -->
                <img src="{{ $item['image'] }}" 
                     alt="{{ $item['title'] ?? 'Gallery Image' }}" 
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                     loading="lazy">
                
                @if($showOverlay)
                <!-- Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                            <i class="fas fa-search-plus text-3xl mb-3"></i>
                            @if(isset($item['title']))
                                <h4 class="font-semibold text-lg mb-2">{{ $item['title'] }}</h4>
                            @endif
                            @if(isset($item['description']))
                                <p class="text-sm text-gray-200">{{ $item['description'] }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Action buttons -->
                    <div class="absolute top-4 right-4 flex space-x-2 transform translate-x-8 group-hover:translate-x-0 transition-transform duration-300">
                        @if($showModal)
                        <button class="bg-white/20 backdrop-blur-sm text-white p-2 rounded-full hover:bg-white/30 transition-colors" 
                                title="Lihat Besar">
                            <i class="fas fa-expand"></i>
                        </button>
                        @endif
                        
                        @if(isset($item['downloadable']) && $item['downloadable'])
                        <a href="{{ $item['image'] }}" 
                           download 
                           class="bg-white/20 backdrop-blur-sm text-white p-2 rounded-full hover:bg-white/30 transition-colors" 
                           title="Download">
                            <i class="fas fa-download"></i>
                        </a>
                        @endif
                    </div>
                </div>
                @endif
                
                <!-- Category Badge -->
                @if(isset($item['category']))
                <div class="absolute top-4 left-4">
                    <span class="bg-hastana-blue text-white px-3 py-1 rounded-full text-xs font-medium">
                        {{ $item['category'] }}
                    </span>
                </div>
                @endif
                
            </div>
        </div>
    @endforeach
</div>

@if($showModal)
<!-- Modal -->
<div id="galleryModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/90 backdrop-blur-sm">
    <div class="relative max-w-7xl max-h-full mx-4">
        
        <!-- Close Button -->
        <button onclick="closeGalleryModal()" 
                class="absolute top-4 right-4 z-10 bg-white/20 backdrop-blur-sm text-white p-3 rounded-full hover:bg-white/30 transition-colors">
            <i class="fas fa-times text-xl"></i>
        </button>
        
        <!-- Navigation Buttons -->
        <button onclick="previousImage()" 
                class="absolute left-4 top-1/2 transform -translate-y-1/2 z-10 bg-white/20 backdrop-blur-sm text-white p-3 rounded-full hover:bg-white/30 transition-colors">
            <i class="fas fa-chevron-left text-xl"></i>
        </button>
        
        <button onclick="nextImage()" 
                class="absolute right-4 top-1/2 transform -translate-y-1/2 z-10 bg-white/20 backdrop-blur-sm text-white p-3 rounded-full hover:bg-white/30 transition-colors">
            <i class="fas fa-chevron-right text-xl"></i>
        </button>
        
        <!-- Image Container -->
        <div class="relative">
            <img id="modalImage" 
                 src="" 
                 alt="" 
                 class="max-w-full max-h-screen object-contain rounded-lg">
            
            <!-- Image Info -->
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent text-white p-6">
                <h3 id="modalTitle" class="text-2xl font-bold mb-2"></h3>
                <p id="modalDescription" class="text-gray-200 mb-4"></p>
                <div class="flex items-center justify-between">
                    <div id="modalMeta" class="text-sm text-gray-300"></div>
                    <div class="flex space-x-2">
                        <button onclick="downloadCurrentImage()" class="bg-hastana-blue hover:bg-blue-700 text-white px-4 py-2 rounded-full text-sm transition-colors">
                            <i class="fas fa-download mr-2"></i>Download
                        </button>
                        <button onclick="shareCurrentImage()" class="bg-hastana-red hover:bg-red-700 text-white px-4 py-2 rounded-full text-sm transition-colors">
                            <i class="fas fa-share mr-2"></i>Share
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Thumbnails -->
        <div class="mt-4 flex justify-center space-x-2 overflow-x-auto pb-2">
            <div id="thumbnails" class="flex space-x-2"></div>
        </div>
    </div>
</div>
@endif

<script>
@if($showModal)
let galleryItems = @json($items);
let currentImageIndex = 0;

function openGalleryModal(index) {
    currentImageIndex = index;
    updateModalImage();
    document.getElementById('galleryModal').classList.remove('hidden');
    document.getElementById('galleryModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeGalleryModal() {
    document.getElementById('galleryModal').classList.add('hidden');
    document.getElementById('galleryModal').classList.remove('flex');
    document.body.style.overflow = 'auto';
}

function updateModalImage() {
    const item = galleryItems[currentImageIndex];
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('modalTitle');
    const modalDescription = document.getElementById('modalDescription');
    const modalMeta = document.getElementById('modalMeta');
    
    modalImage.src = item.image;
    modalImage.alt = item.title || 'Gallery Image';
    modalTitle.textContent = item.title || '';
    modalDescription.textContent = item.description || '';
    modalMeta.textContent = `${currentImageIndex + 1} of ${galleryItems.length}`;
    
    updateThumbnails();
}

function previousImage() {
    currentImageIndex = (currentImageIndex - 1 + galleryItems.length) % galleryItems.length;
    updateModalImage();
}

function nextImage() {
    currentImageIndex = (currentImageIndex + 1) % galleryItems.length;
    updateModalImage();
}

function updateThumbnails() {
    const thumbnailsContainer = document.getElementById('thumbnails');
    thumbnailsContainer.innerHTML = '';
    
    galleryItems.forEach((item, index) => {
        const thumbnail = document.createElement('img');
        thumbnail.src = item.image;
        thumbnail.className = `w-16 h-16 object-cover rounded cursor-pointer transition-all duration-200 ${index === currentImageIndex ? 'ring-2 ring-white' : 'opacity-70 hover:opacity-100'}`;
        thumbnail.onclick = () => {
            currentImageIndex = index;
            updateModalImage();
        };
        thumbnailsContainer.appendChild(thumbnail);
    });
}

function downloadCurrentImage() {
    const item = galleryItems[currentImageIndex];
    const link = document.createElement('a');
    link.href = item.image;
    link.download = item.title || `image-${currentImageIndex + 1}`;
    link.click();
}

function shareCurrentImage() {
    const item = galleryItems[currentImageIndex];
    if (navigator.share) {
        navigator.share({
            title: item.title || 'Gallery Image',
            text: item.description || '',
            url: item.image
        });
    } else {
        // Fallback: copy URL to clipboard
        navigator.clipboard.writeText(item.image).then(() => {
            alert('Link gambar telah disalin ke clipboard!');
        });
    }
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('galleryModal');
    if (!modal.classList.contains('hidden')) {
        if (e.key === 'Escape') closeGalleryModal();
        if (e.key === 'ArrowLeft') previousImage();
        if (e.key === 'ArrowRight') nextImage();
    }
});

// Click outside to close
document.getElementById('galleryModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeGalleryModal();
});
@endif
</script>

<style>
.gallery-item {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.gallery-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

/* Modal animation */
#galleryModal {
    animation: modalFadeIn 0.3s ease-out;
}

@keyframes modalFadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
</style>