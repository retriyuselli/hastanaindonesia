@props([
    'name',
    'label' => null,
    'type' => 'text',
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'icon' => null,
    'iconPosition' => 'left',
    'help' => null,
    'error' => null
])

<div class="space-y-2">
    @if($label)
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
        {{ $label }}
        @if($required)
            <span class="text-red-500 ml-1">*</span>
        @endif
    </label>
    @endif

    <div class="relative">
        @if($icon && $iconPosition === 'left')
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="{{ $icon }} text-gray-400"></i>
        </div>
        @endif

        <input 
            type="{{ $type }}" 
            name="{{ $name }}" 
            id="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            {{ $attributes->merge([
                'class' => 'block w-full rounded-lg border-gray-300 shadow-sm transition-colors duration-200 focus:border-hastana-blue focus:ring-hastana-blue focus:ring-2 focus:ring-opacity-20 disabled:bg-gray-100 disabled:cursor-not-allowed' . 
                ($icon && $iconPosition === 'left' ? ' pl-10' : '') . 
                ($icon && $iconPosition === 'right' ? ' pr-10' : '') .
                ($error ? ' border-red-500 focus:border-red-500 focus:ring-red-500' : '')
            ]) }}
        >

        @if($icon && $iconPosition === 'right')
        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <i class="{{ $icon }} text-gray-400"></i>
        </div>
        @endif
    </div>

    @if($error)
    <p class="text-sm text-red-600">
        <i class="fas fa-exclamation-circle mr-1"></i>
        {{ $error }}
    </p>
    @elseif($help)
    <p class="text-sm text-gray-500">{{ $help }}</p>
    @endif
</div>