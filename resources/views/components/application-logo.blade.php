<div {{ $attributes->merge(['class' => 'flex items-center justify-center']) }}>
    <!-- HASTANA Indonesia Logo -->
    <div class="flex items-center space-x-3">
        <!-- Logo Icon -->
        <div class="relative">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-700 to-red-600 rounded-full flex items-center justify-center shadow-lg">
                <div class="w-8 h-8 border-2 border-white rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L13.09 8.26L22 9L13.09 9.74L12 16L10.91 9.74L2 9L10.91 8.26L12 2Z"/>
                    </svg>
                </div>
            </div>
            <!-- Subtle ring animation -->
            <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-red-600 rounded-full opacity-20"></div>
        </div>
        
        <!-- Logo Text -->
        <div class="flex flex-col">
            <h1 class="text-xl font-bold text-gray-800 leading-tight">
                HASTANA
            </h1>
            <span class="text-xs text-gray-600 font-medium tracking-wide -mt-1">
                INDONESIA
            </span>
        </div>
    </div>
</div>
