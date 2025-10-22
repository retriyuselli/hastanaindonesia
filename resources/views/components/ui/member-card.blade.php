@props([
    'name' => '',
    'brand' => '',
    'image' => null,
    'location' => '',
    'specialization' => '',
    'rating' => 0,
    'completedEvents' => 0,
    'certification' => '',
    'url' => '#',
    'verified' => false,
    'featured' => false,
    'contact' => []
])

<div class="bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 group">
    
    <!-- Image & Status -->
    <div class="relative aspect-[4/3] overflow-hidden">
        <img src="{{ $image ?? asset('images/default-avatar.png') }}" 
             alt="{{ $name }}" 
             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
        
        <!-- Badges -->
        <div class="absolute top-4 left-4 space-y-2">
            @if($verified)
            <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-semibold flex items-center">
                <i class="fas fa-check-circle mr-1"></i>Verified
            </span>
            @endif
            
            @if($featured)
            <span class="bg-hastana-red text-white px-2 py-1 rounded-full text-xs font-semibold flex items-center">
                <i class="fas fa-star mr-1"></i>Featured
            </span>
            @endif
        </div>
        
        @if($certification)
        <div class="absolute top-4 right-4">
            <span class="bg-hastana-blue text-white px-2 py-1 rounded-full text-xs font-medium">
                {{ $certification }}
            </span>
        </div>
        @endif
        
        <!-- Hover Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <div class="absolute bottom-4 left-4 right-4">
                <div class="flex items-center justify-between text-white">
                    <span class="text-sm font-medium">Lihat Profil</span>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Content -->
    <div class="p-6">
        
        <!-- Name & Brand -->
        <div class="mb-4">
            <h3 class="text-xl font-bold text-gray-900 mb-1 line-clamp-1">
                <a href="{{ $url }}" class="hover:text-hastana-blue transition-colors">{{ $name }}</a>
            </h3>
            @if($brand)
            <p class="text-hastana-blue font-medium text-sm">{{ $brand }}</p>
            @endif
        </div>
        
        <!-- Location -->
        @if($location)
        <div class="flex items-center text-gray-600 mb-3">
            <i class="fas fa-map-marker-alt text-hastana-red mr-2"></i>
            <span class="text-sm">{{ $location }}</span>
        </div>
        @endif
        
        <!-- Specialization -->
        @if($specialization)
        <div class="flex items-center text-gray-600 mb-4">
            <i class="fas fa-heart text-hastana-red mr-2"></i>
            <span class="text-sm">{{ $specialization }}</span>
        </div>
        @endif
        
        <!-- Stats -->
        <div class="grid grid-cols-2 gap-4 mb-4 pt-4 border-t border-gray-100">
            @if($rating > 0)
            <div class="text-center">
                <div class="flex items-center justify-center mb-1">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star text-xs {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                    @endfor
                </div>
                <p class="text-xs text-gray-500">Rating</p>
            </div>
            @endif
            
            @if($completedEvents > 0)
            <div class="text-center">
                <p class="text-lg font-bold text-hastana-blue">{{ number_format($completedEvents) }}</p>
                <p class="text-xs text-gray-500">Event Selesai</p>
            </div>
            @endif
        </div>
        
        <!-- Contact Actions -->
        <div class="flex items-center space-x-2">
            <a href="{{ $url }}" class="flex-1 bg-hastana-blue text-white py-2 px-4 rounded-full text-sm font-medium text-center hover:bg-blue-800 transition-colors">
                <i class="fas fa-eye mr-1"></i>Lihat Profil
            </a>
            
            @if(isset($contact['whatsapp']))
            <a href="https://wa.me/{{ $contact['whatsapp'] }}" 
               class="bg-green-500 text-white p-2 rounded-full hover:bg-green-600 transition-colors" 
               title="WhatsApp">
                <i class="fab fa-whatsapp text-sm"></i>
            </a>
            @endif
            
            @if(isset($contact['instagram']))
            <a href="https://instagram.com/{{ $contact['instagram'] }}" 
               class="bg-pink-500 text-white p-2 rounded-full hover:bg-pink-600 transition-colors" 
               title="Instagram">
                <i class="fab fa-instagram text-sm"></i>
            </a>
            @endif
        </div>
        
        <!-- Slot for additional content -->
        {{ $slot }}
    </div>
</div>

<style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>