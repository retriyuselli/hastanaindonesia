@props([
    'title' => 'HASTANA Indonesia',
    'subtitle' => 'Himpunan Perusahaan Penata Acara Seluruh Indonesia',
    'description' => 'Organisasi resmi yang menaungi para wedding organizer profesional di Indonesia',
    'backgroundImage' => null,
    'height' => 'min-h-screen',
    'overlay' => true,
    'centered' => true,
    'buttons' => []
])

<section class="hero-bg {{ $height }} flex items-center justify-center relative overflow-hidden" 
         @if($backgroundImage) style="background-image: url('{{ $backgroundImage }}')" @endif>
    
    @if($overlay)
    <!-- Overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-black/70 via-hastana-blue/60 to-hastana-red/50"></div>
    @endif
    
    <!-- Hero Content -->
    <div class="relative z-10 container mx-auto px-4 {{ $centered ? 'text-center' : '' }}">
        <div class="max-w-4xl {{ $centered ? 'mx-auto' : '' }}">
            
            <!-- Title -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                {{ $title }}
            </h1>
            
            <!-- Subtitle -->
            @if($subtitle)
            <h2 class="text-xl md:text-2xl lg:text-3xl text-gray-200 mb-6 font-medium">
                {{ $subtitle }}
            </h2>
            @endif
            
            <!-- Description -->
            @if($description)
            <p class="text-lg md:text-xl text-gray-300 mb-8 leading-relaxed max-w-2xl {{ $centered ? 'mx-auto' : '' }}">
                {{ $description }}
            </p>
            @endif
            
            <!-- Buttons -->
            @if(!empty($buttons))
            <div class="flex flex-col sm:flex-row gap-4 {{ $centered ? 'justify-center' : '' }}">
                @foreach($buttons as $button)
                    <a href="{{ $button['url'] }}" 
                       class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold rounded-full transition-all duration-300 transform hover:scale-105 {{ $button['class'] ?? 'bg-hastana-red hover:bg-red-700 text-white' }}">
                        @if(isset($button['icon']))
                            <i class="{{ $button['icon'] }} mr-2"></i>
                        @endif
                        {{ $button['text'] }}
                    </a>
                @endforeach
            </div>
            @endif
            
            <!-- Slot for additional content -->
            {{ $slot }}
            
        </div>
    </div>
    
    <!-- Decorative Elements -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Floating shapes -->
        <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-white/5 rounded-full animate-pulse"></div>
        <div class="absolute top-3/4 right-1/4 w-24 h-24 bg-hastana-red/20 rounded-full floating-animation"></div>
        <div class="absolute bottom-1/4 left-1/3 w-16 h-16 bg-hastana-blue/20 rounded-full floating-animation" style="animation-delay: 2s;"></div>
        
        <!-- Geometric patterns -->
        <div class="absolute top-0 right-0 w-96 h-96 opacity-10">
            <svg viewBox="0 0 100 100" class="w-full h-full">
                <defs>
                    <pattern id="wedding-rings" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                        <circle cx="10" cy="10" r="8" fill="none" stroke="currentColor" stroke-width="0.5"/>
                        <circle cx="10" cy="10" r="4" fill="none" stroke="currentColor" stroke-width="0.3"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#wedding-rings)"/>
            </svg>
        </div>
    </div>
</section>

<style>
.hero-bg {
    background: linear-gradient(135deg, rgba(26, 26, 26, 0.7), rgba(30, 64, 175, 0.6), rgba(220, 38, 38, 0.5)),
               url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><defs><pattern id="wedding-pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="20" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/><circle cx="50" cy="50" r="10" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23wedding-pattern)"/></svg>');
    background-size: cover, 100px 100px;
    background-position: center, 0 0;
    background-attachment: fixed;
}

.floating-animation {
    animation: float 6s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .hero-bg {
        background-attachment: scroll;
    }
}
</style>