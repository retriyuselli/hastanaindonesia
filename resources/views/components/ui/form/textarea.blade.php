@props([
    'name',
    'label' => null,
    'placeholder' => '',
    'value' => '',
    'rows' => 4,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
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

    <textarea 
        name="{{ $name }}" 
        id="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
        @if($disabled) disabled @endif
        @if($readonly) readonly @endif
        {{ $attributes->merge([
            'class' => 'block w-full rounded-lg border-gray-300 shadow-sm transition-colors duration-200 focus:border-hastana-blue focus:ring-hastana-blue focus:ring-2 focus:ring-opacity-20 disabled:bg-gray-100 disabled:cursor-not-allowed resize-y' . 
            ($error ? ' border-red-500 focus:border-red-500 focus:ring-red-500' : '')
        ]) }}
    >{{ old($name, $value) }}</textarea>

    @if($error)
    <p class="text-sm text-red-600">
        <i class="fas fa-exclamation-circle mr-1"></i>
        {{ $error }}
    </p>
    @elseif($help)
    <p class="text-sm text-gray-500">{{ $help }}</p>
    @endif
</div>