@props([
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'iconPosition' => 'left',
    'loading' => false,
    'disabled' => false,
    'href' => null,
    'type' => 'button'
])

@php
$baseClasses = 'inline-flex items-center justify-center font-medium rounded-full transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-105 active:scale-95';

$variants = [
    'primary' => 'bg-hastana-blue hover:bg-blue-800 text-white focus:ring-hastana-blue',
    'secondary' => 'bg-hastana-red hover:bg-red-700 text-white focus:ring-hastana-red',
    'outline' => 'border-2 border-hastana-blue text-hastana-blue hover:bg-hastana-blue hover:text-white focus:ring-hastana-blue',
    'outline-red' => 'border-2 border-hastana-red text-hastana-red hover:bg-hastana-red hover:text-white focus:ring-hastana-red',
    'outline-white' => 'border-2 border-white text-white hover:bg-white hover:text-gray-900 focus:ring-white',
    'ghost' => 'text-hastana-blue hover:bg-blue-50 focus:ring-hastana-blue',
    'white' => 'bg-white text-gray-900 hover:bg-gray-50 shadow-md focus:ring-gray-500',
    'dark' => 'bg-gray-900 hover:bg-gray-800 text-white focus:ring-gray-900',
];

$sizes = [
    'xs' => 'px-3 py-1.5 text-xs',
    'sm' => 'px-4 py-2 text-sm',
    'md' => 'px-6 py-3 text-base',
    'lg' => 'px-8 py-4 text-lg',
    'xl' => 'px-10 py-5 text-xl',
];

$classes = $baseClasses . ' ' . $variants[$variant] . ' ' . $sizes[$size];

if ($disabled || $loading) {
    $classes .= ' cursor-not-allowed opacity-50';
}
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($loading)
            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @endif
        
        @if($icon && $iconPosition === 'left' && !$loading)
            <i class="{{ $icon }} {{ $slot->isNotEmpty() ? 'mr-2' : '' }}"></i>
        @endif
        
        {{ $slot }}
        
        @if($icon && $iconPosition === 'right' && !$loading)
            <i class="{{ $icon }} {{ $slot->isNotEmpty() ? 'ml-2' : '' }}"></i>
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }} @if($disabled || $loading) disabled @endif>
        @if($loading)
            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @endif
        
        @if($icon && $iconPosition === 'left' && !$loading)
            <i class="{{ $icon }} {{ $slot->isNotEmpty() ? 'mr-2' : '' }}"></i>
        @endif
        
        {{ $slot }}
        
        @if($icon && $iconPosition === 'right' && !$loading)
            <i class="{{ $icon }} {{ $slot->isNotEmpty() ? 'ml-2' : '' }}"></i>
        @endif
    </button>
@endif