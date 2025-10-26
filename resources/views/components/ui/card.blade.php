@props([
    'title' => '',
    'description' => '',
    'image' => null,
    'url' => '#',
    'date' => null,
    'author' => null,
    'category' => null,
    'featured' => false,
    'hover' => true,
    'showReadMore' => true
])

<article class="bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 {{ $hover ? 'hover:shadow-2xl hover:-translate-y-2' : '' }} {{ $featured ? 'ring-2 ring-hastana-blue' : '' }}">
    
    @if($image)
    <!-- Image -->
    <div class="relative overflow-hidden aspect-[16/10]">
        <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
        
        @if($featured)
        <div class="absolute top-4 left-4">
            <span class="bg-hastana-red text-white px-3 py-1 rounded-full text-xs font-semibold">
                <i class="fas fa-star mr-1"></i>Featured
            </span>
        </div>
        @endif
        
        @if($category)
        <div class="absolute top-4 right-4">
            <span class="bg-black/70 text-white px-3 py-1 rounded-full text-xs font-medium">
                {{ $category }}
            </span>
        </div>
        @endif
        
        <!-- Overlay on hover -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300">
            <div class="absolute bottom-4 left-4 right-4">
                <div class="flex items-center justify-between text-white">
                    <span class="text-sm">
                        <i class="fas fa-eye mr-1"></i>Lihat Detail
                    </span>
                    <i class="fas fa-arrow-right text-lg"></i>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Content -->
    <div class="p-6">
        
        <!-- Meta Info -->
        @if($date || $author)
        <div class="flex items-center text-sm text-gray-500 mb-3 space-x-4">
            @if($date)
            <div class="flex items-center">
                <i class="fas fa-calendar-alt mr-2 text-hastana-blue"></i>
                <time datetime="{{ $date }}">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</time>
            </div>
            @endif
            
            @if($author)
            <div class="flex items-center">
                <i class="fas fa-user mr-2 text-hastana-blue"></i>
                <span>{{ $author }}</span>
            </div>
            @endif
        </div>
        @endif
        
        <!-- Title -->
        <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 hover:text-hastana-blue transition-colors">
            <a href="{{ $url }}" class="stretched-link">{{ $title }}</a>
        </h3>
        
        <!-- Description -->
        @if($description)
        <p class="text-gray-600 mb-4 line-clamp-3 leading-relaxed">
            {{ $description }}
        </p>
        @endif
        
        <!-- Slot for additional content -->
        {{ $slot }}
        
        <!-- Read More Link -->
        @if($showReadMore)
        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
            <a href="{{ $url }}" class="text-hastana-blue font-medium text-sm hover:text-hastana-red transition-colors">
                Selengkapnya
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
            
            <!-- Additional actions -->
            <div class="flex items-center space-x-2">
                <button class="text-gray-400 hover:text-hastana-red transition-colors" title="Suka">
                    <i class="fas fa-heart"></i>
                </button>
                <button class="text-gray-400 hover:text-hastana-blue transition-colors" title="Bagikan">
                    <i class="fas fa-share-alt"></i>
                </button>
            </div>
        </div>
        @endif
    </div>
</article>

<style>
/* Line clamp utilities */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Stretched link for better click area */
.stretched-link::after {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1;
    content: "";
}
</style>